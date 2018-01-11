<?php

namespace Guj\DataPush\Provider;

use Aws\Exception\AwsException;
use Aws\Result;
use Aws\Sqs\Exception\SqsException;
use Aws\Sqs\SqsClient;
use Guj\DataPush\Exception\GujDataPushException;
use Guj\DataPush\Model\AwsQueueCollection;

/**
 * Provider for interaction with Amazon AWS-SQS
 *
 * @package Guj\DataPush\Provider
 */
class GujAwsSqsProvider extends ConfigureableProvider
{

    /** Namespace / prefix for configuration values */
    const CONFIG_NAMESPACE = 'aws_sqs';
    /** region for aws sqs call */
    const CONFIG_KEY_REGION = 'aws_sqs_region';
    /** queue-name for aws sqs call */
    const CONFIG_KEY_QUEUE_NAME = 'aws_sqs_queue_name';
    /** key for connection authorization */
    const CONFIG_KEY_AWS_KEY = 'aws_sqs_key';
    /** secret for connection authorization */
    const CONFIG_KEY_AWS_SECRET = 'aws_sqs_secret';
    /** default region */
    const AWS_REGION_DEFAULT = 'eu-west-1';

    /**
     * Create SqsClient
     *
     * @return SqsClient
     * @throws GujDataPushException
     */
    protected function createSqsClient(){

        $region = $this->getConfigValue('region', self::AWS_REGION_DEFAULT);
        $key = $this->getConfigValue('key');
        $secret = $this->getConfigValue('secret');
        $sqsClient = new SqsClient(
            array(
                'region'      => $region,
                'version'     => '2012-11-05', // current version see http://docs.aws.amazon.com/aws-sdk-php/v3/api/index.html
                'credentials' => array(
                    'key'    => $key,
                    'secret' => $secret,
                )
            )
        );
        return $sqsClient;
    }

    /**
     * Create new Aws Queue Collection
     *
     * @return AwsQueueCollection
     */
    protected function createAwsQueueCollection(){
        return new AwsQueueCollection();
    }

    /**
     * Push string to sqs queue
     *
     * @param        $version
     * @param        $client
     * @param        $producer
     * @param string $data
     *
     * @return bool
     *
     * @throws GujDataPushException
     */
    public function push($version, $client, $producer, $data)
    {
        $queueName = $this->getConfigValue('queue_name');

        // create sqs client
        $sqsClient = $this->createSqsClient();

        try {
            // get queues, create them if needed
            $queueCollection = $this->createQueuesIfNotExists($sqsClient, $queueName);
            // set params for message push
            $sqsParams = array(
                'MessageAttributes' => array(
                    'Origin'   => array(
                        'DataType'    => 'String',
                        'StringValue' => 'GujDataPush'
                    ),
                    'Producer' => array(
                        'DataType'    => 'String',
                        'StringValue' => $producer
                    ),
                    'Client'   => array(
                        'DataType'    => 'String',
                        'StringValue' => $client
                    ),
                    'Version'  => array(
                        'DataType'    => 'String',
                        'StringValue' => $version
                    )
                ),
                'MessageBody'       => $data,
                'QueueUrl'          => $queueCollection->getStandardQueue()->getUrl()
            );

            // send message
            /** @var Result $result */
            $result = $sqsClient->sendMessage($sqsParams);
            $metaData = $result->get('@metadata');
            if (isset($metaData['statusCode'])) {
                $messageResult = ($metaData['statusCode'] === 200);
            } else {
                throw new GujDataPushException('Invalid response from AWS', GujDataPushException::UNDEFINED_EXCEPTION_CODE);
            }
        } catch (SqsException $e) {
            throw new GujDataPushException($e->getMessage(), GujDataPushException::AWS_SQS_EXCEPTION_CODE, $e);
        } catch (AwsException $e) {
            throw new GujDataPushException($e->getMessage(), GujDataPushException::AWS_EXCEPTION_CODE, $e);
        } catch (\Exception $e) {
            throw new GujDataPushException($e->getMessage(), GujDataPushException::UNDEFINED_EXCEPTION_CODE, $e);
        }

        return $messageResult;
    }

    /**
     * Check if AWS-SQS Queue exists with same name and parameters. Create queue if not exist
     *
     * @param SqsClient $sqsClient
     * @param string    $queueName
     *
     * @return AwsQueueCollection
     */
    private function createQueuesIfNotExists(SqsClient &$sqsClient, $queueName)
    {

        $queueCollection = $this->createAwsQueueCollection();

        /** @var Result $result */
        $createFatalQueueResult = $sqsClient->createQueue(
            array(
                'QueueName' => $queueName . '_fatal'
            )
        );
        $fatalQueueUrl = $createFatalQueueResult->get('QueueUrl');
        $fatalQueueArn = $sqsClient->getQueueArn($fatalQueueUrl);
        $queueCollection->getFatalQueue()->setUrl($fatalQueueUrl);
        $queueCollection->getFatalQueue()->setArn($fatalQueueArn);

        /** @var Result $result */
        $createErrorQueueResult = $sqsClient->createQueue(
            array(
                'QueueName'  => $queueName . '_error',
                'Attributes' => array(
                    'RedrivePolicy' => '{"deadLetterTargetArn":"' . $fatalQueueArn . '","maxReceiveCount":"5"}'
                )
            )
        );
        $errorQueueUrl = $createErrorQueueResult->get('QueueUrl');
        $errorQueueArn = $sqsClient->getQueueArn($errorQueueUrl);

        $queueCollection->getErrorQueue()->setUrl($errorQueueUrl);
        $queueCollection->getErrorQueue()->setArn($errorQueueArn);

        /** @var Result $result */
        $createStandardQueueResult = $sqsClient->createQueue(
            array(
                'QueueName'  => $queueName,
                'Attributes' => array(
                    'RedrivePolicy' => '{"deadLetterTargetArn":"' . $errorQueueArn . '","maxReceiveCount":"5"}'
                )
            )
        );
        $standardQueueUrl = $createStandardQueueResult->get('QueueUrl');
        $standardQueueArn = $sqsClient->getQueueArn($standardQueueUrl);

        $queueCollection->getStandardQueue()->setUrl($standardQueueUrl);
        $queueCollection->getStandardQueue()->setArn($standardQueueArn);

        return $queueCollection;
    }

}
