<?php

use Aws\Result as AwsResult;
use Aws\Sqs\SqsClient;
use Codeception\Util\Stub;
use Guj\DataPush\Exception\GujDataPushException;
use Guj\DataPush\Model\AwsQueue;
use Guj\DataPush\Model\AwsQueueCollection;
use Guj\DataPush\Provider\GujAwsSqsProvider;

/**
 * Class GujAwsSqsProviderTest
 */
class GujAwsSqsProviderTest extends \Codeception\Test\Unit
{
    /** @var \UnitTester */
    protected $tester;

    /** @var SqsClient|PHPUnit_Framework_MockObject_MockObject */
    protected $sqsClientStub;
    /** @var Stub|PHPUnit_Framework_MockObject_MockObject */
    protected $awsStandardQueueStub;
    /** @var Stub|PHPUnit_Framework_MockObject_MockObject */
    protected $awsErrorQueueStub;
    /** @var Stub|PHPUnit_Framework_MockObject_MockObject */
    protected $awsFatalQueueStub;
    /** @var Stub|PHPUnit_Framework_MockObject_MockObject */
    protected $awsQueueCollectionStub;
    /** @var Stub|PHPUnit_Framework_MockObject_MockObject */
    protected $awsProviderStub;

    /**
     * Create common Stubs
     */
    protected function setUp()
    {
        $this->createStubs();
        parent::setUp();
    }

    /**
     * Test createQeuesIfNotExists to ensure its behavior
     */
    public function testCreateQueuesIfNotExists()
    {
        // create custom stub
        /** @var GujAwsSqsProvider $awsProviderStub */
        $awsProviderStub = Stub::make(
            GujAwsSqsProvider::class,
            array(
                'createSqsClient'          => function () {
                    return $this->sqsClientStub;
                },
                'createAwsQueueCollection' => function () {
                    return $this->awsQueueCollectionStub;
                },
                'createQueuesIfNotExists'  => function ($sqsClient, $queueName) {
                    return $this->awsQueueCollectionStub;
                },
                'getConfigValue'           => function ($param) {
                    return 'SampleQueue';
                }
            )
        );
        // build reflection class to call private/protected methods
        $reflector = new \ReflectionClass($awsProviderStub);
        // get private/protected method to call
        $configMethod = $reflector->getMethod('configure');
        // change accessability
        $configMethod->setAccessible(true);
        // get private/protected method to call
        $method = $reflector->getMethod('createQueuesIfNotExists');
        // change accessability
        $method->setAccessible(true);
        // configure provider
        $configMethod->invokeArgs($awsProviderStub, [['aws_sqs_queue_name' => 'SampleQueue']]);
        /** @var \Guj\DataPush\Model\AwsQueueCollection $queueCollection */
        $queueCollection = $method->invokeArgs($awsProviderStub, [&$this->sqsClientStub, 'SampleQueue']);
        // assertions
        $this->assertEquals($this->awsStandardQueueStub, $queueCollection->getStandardQueue());
        $this->assertEquals($this->awsErrorQueueStub, $queueCollection->getErrorQueue());
        $this->assertEquals($this->awsFatalQueueStub, $queueCollection->getFatalQueue());
    }

    /**
     * Test push method to ensure its behavior and exception handling
     */
    public function testPush()
    {
        // build reflection class to call private/protected methods
        $reflector = new \ReflectionClass($this->awsProviderStub);
        $configMethod = $reflector->getMethod('configure');
        // change accessability
        $configMethod->setAccessible(true);
        // configure provider
        /** @var \Guj\DataPush\Model\AwsQueueCollection $queueCollection */
        $configMethod->invokeArgs($this->awsProviderStub, [['aws_sqs_queue_name' => 'SampleQueue', 'aws_sqs_region' => 'SampleRegion', 'aws_sqs_key' => 'SampleKey', 'aws_sqs_secret' => 'SampleSecret']]);
        // call
        $messageResult = $this->awsProviderStub->push("1.0", "SampleClient", "SampleProducer", "TestData");
        $this->assertEquals(true, $messageResult);

        // create custom stub
        /** @var Stub|PHPUnit_Framework_MockObject_MockObject $sqsClientExceptionStub */
        $sqsClientExceptionStub = Stub::make(
            SqsClient::class,
            array(
                '__call' => function ($method, $arguments) {
                    $arguments = $arguments[0];
                    if ($method == "createQueue") {
                        $result = new AwsResult(['QueueUrl' => 'http://sample.com/' . $arguments['QueueName']]);

                        return $result;
                    }
                    if ($method == "sendMessage") {
                        $result = new AwsResult([]);

                        return $result;
                    }

                    return false;
                }
            )
        );

        // create custom stub
        /** @var GujAwsSqsProvider $awsProviderStub */
        $awsProviderExceptionStub = Stub::construct(
            GujAwsSqsProvider::class,
            array(),
            array(
                'createSqsClient'          => function () use ($sqsClientExceptionStub) {
                    return $sqsClientExceptionStub;
                },
                'createAwsQueueCollection' => function () {
                    return $this->awsQueueCollectionStub;
                },
                'createQueuesIfNotExists'  => function ($sqsClient, $queueName) {
                    return $this->awsQueueCollectionStub;
                },
                'getConfigValue'           => function ($configKey) {
                    return "Sample" . ucfirst($configKey);
                }
            )
        );

        // check exception handling
        $exspectedException = new GujDataPushException('Invalid response from AWS', GujDataPushException::UNDEFINED_EXCEPTION_CODE);
        $this->tester->expectException(
            $exspectedException,
            function () use ($awsProviderExceptionStub) {
                $awsProviderExceptionStub->push("1.0", "SampleClient", "SampleProducer", "TestData");
            }
        );

        // change stub to test SqsException
        Stub::update(
            $sqsClientExceptionStub,
            array(
                '__call' => function ($method, $arguments) {
                    $arguments = $arguments[0];
                    if ($method == "createQueue") {
                        $result = new AwsResult(['QueueUrl' => 'http://sample.com/' . $arguments['QueueName']]);

                        return $result;
                    }
                    if ($method == "sendMessage") {
                        throw new \Aws\Sqs\Exception\SqsException("SampleMessage", new \Aws\Command("SampleCommand"));
                    }

                    return false;
                }
            )
        );

        // check exception handling
        $exspectedException = new GujDataPushException("SampleMessage", GujDataPushException::AWS_SQS_EXCEPTION_CODE);
        $this->tester->expectException(
            $exspectedException,
            function () use ($awsProviderExceptionStub) {
                $awsProviderExceptionStub->push("1.0", "SampleClient", "SampleProducer", "TestData");
            }
        );

        // change stub to test AwsException
        Stub::update(
            $sqsClientExceptionStub,
            array(
                '__call' => function ($method, $arguments) {
                    $arguments = $arguments[0];
                    if ($method == "createQueue") {
                        $result = new AwsResult(['QueueUrl' => 'http://sample.com/' . $arguments['QueueName']]);

                        return $result;
                    }
                    if ($method == "sendMessage") {
                        throw new \Aws\Exception\AwsException("SampleMessage", new \Aws\Command("SampleCommand"));
                    }

                    return false;
                }
            )
        );

        // check exception handling
        $exspectedException = new GujDataPushException("SampleMessage", GujDataPushException::AWS_EXCEPTION_CODE);
        $this->tester->expectException(
            $exspectedException,
            function () use ($awsProviderExceptionStub) {
                $awsProviderExceptionStub->push("1.0", "SampleClient", "SampleProducer", "TestData");
            }
        );
    }

    /**
     * Test createAwsQueueCollection to ensure return value
     */
    public function testCreateAwsQueueCollection()
    {
        /** @var GujAwsSqsProvider $awsProviderStub */
        $awsProviderStub = Stub::make(
            GujAwsSqsProvider::class,
            array()
        );
        // build reflection class to call private/protected methods
        $reflector = new \ReflectionClass($awsProviderStub);
        // get private/protected method to call
        $createAwsQueueCollectionMethod = $reflector->getMethod('createAwsQueueCollection');
        // change accessability
        $createAwsQueueCollectionMethod->setAccessible(true);
        // invoke method
        $awsQueueCollection = $createAwsQueueCollectionMethod->invoke($awsProviderStub);
        // assertions
        $this->assertInstanceOf(AwsQueueCollection::class, $awsQueueCollection);
    }

    /**
     * Test createClient to ensure return value
     */
    public function testCreateSqsClient()
    {
        /** @var GujAwsSqsProvider $awsProviderStub */
        $awsProviderStub = Stub::make(
            GujAwsSqsProvider::class,
            array(
                'createAwsQueueCollection' => function () {
                    return $this->awsQueueCollectionStub;
                },
                'createQueuesIfNotExists'  => function ($sqsClient, $queueName) {
                    return $this->awsQueueCollectionStub;
                },
                'getConfigValue'           => function ($configKey) {
                    return "Sample" . ucfirst($configKey);
                }
            )
        );
        // build reflection class to call private/protected methods
        $reflector = new \ReflectionClass($awsProviderStub);
        // get private/protected method to call
        $createSqsClientMethod = $reflector->getMethod('createSqsClient');
        // change accessability
        $createSqsClientMethod->setAccessible(true);
        // invoke method
        $sqsClient = $createSqsClientMethod->invoke($awsProviderStub);
        // assertions
        $this->assertInstanceOf(SqsClient::class, $sqsClient);
    }

    /***********************
     *       Stubs         *
     ***********************/

    private function createStubs()
    {
        $this->sqsClientStub = $this->createSqsClientStub();
        // create queue stub
        $this->awsStandardQueueStub = Stub::make(
            AwsQueue::class,
            array(
                'getUrl' => function () {
                    return "SampleStandardUrl";
                }
            )
        );

        // create queue stub
        $this->awsErrorQueueStub = Stub::make(
            AwsQueue::class,
            array(
                'getUrl' => function () {
                    return "http://sample.com/SampleQueue_error";
                }
            )
        );
        // create queue stub
        $this->awsFatalQueueStub = Stub::make(
            AwsQueue::class,
            array(
                'getUrl' => function () {
                    return "http://sample.com/SampleQueue_fatal";
                }
            )
        );

        // create queuecollection stub
        $this->awsQueueCollectionStub = Stub::make(
            AwsQueueCollection::class,
            array(
                'getStandardQueue' => function () {
                    return $this->awsStandardQueueStub;
                },
                'getErrorQueue'    => function () {
                    return $this->awsErrorQueueStub;
                },
                'getFatalQueue'    => function () {
                    return $this->awsFatalQueueStub;
                },
            )
        );

        /** @var GujAwsSqsProvider $awsProviderStub */
        $this->awsProviderStub = Stub::construct(
            GujAwsSqsProvider::class,
            array(),
            array(
                'createSqsClient'          => function () {
                    return $this->sqsClientStub;
                },
                'createAwsQueueCollection' => function () {
                    return $this->awsQueueCollectionStub;
                },
                'createQueuesIfNotExists'  => function () {
                    return $this->awsQueueCollectionStub;
                }
            )
        );
    }

    /**
     * @param int $statusCode
     *
     * @return object
     */
    protected function createSqsClientStub($statusCode = 200)
    {
        $sqsClientStub = Stub::make(
            SqsClient::class,
            array(
                '__call'      => function ($method, $arguments) use ($statusCode) {
                    $arguments = $arguments[0];
                    if ($method == "createQueue") {
                        $result = new AwsResult(['QueueUrl' => 'http://sample.com/' . $arguments['QueueName']]);

                        return $result;
                    }
                    if ($method == "sendMessage") {
                        $result = new AwsResult(['@metadata' => array('statusCode' => $statusCode)]);

                        return $result;
                    }

                    return false;
                },
                'getQueueArn' => function ($queueUrl) {
                    return "SampleARN";
                },

            )
        );

        return $sqsClientStub;
    }
}