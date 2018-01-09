<?php

require dirname(__FILE__) . "/../vendor/autoload.php";

use Guj\DataPush\Exception\GujDataPushException;
use Guj\DataPush\Provider\GujDataPushProvider;

/**
 * Configure
 */
GujDataPushProvider::init(
    array(
        // 'aws_sqs_region'      => 'eu-west-1', // default value
        'aws_sqs_queue_name' => '[[ QUEUE_NAME ]]',
        'aws_sqs_key'        => '[[ AWS_KEY ]]',
        'aws_sqs_secret'     => '[[ AWS_SECRET ]]',
    )
);

$data = array(
    'version'           => '1.0.0',
    'producer'          => 'TestProducer',
    'client'            => 'TestClient',
    'type'              => 'data',
    'createdAt'         => '2017-01-01T08:00:00Z',
    'userData'          =>
        array(
            'ssoId'       => '123456789',
            'customerNo'  => '',
            'userName'    => 'johnDoe',
            'name'        => 'John',
            'lastName'    => 'Doe',
            'gender'      => 'm',
            'dateOfBirth' => '1950-01-01T00:11:22Z',
            'email'       => 'mail@example.com',
            'phone'       => '0123456789',
            'mobile'      => '0123456789',
            'company'     => 'Company Ltd.',
            'street'      => 'Teststreet',
            'streetNo'    => '1',
            'careOf'      => 'Mrs. Smith',
            'postcode'    => '12345',
            'city'        => 'SampleCity',
            'country'     => 'SampleCountry',
        ),
    'children'          =>
        array(
            0 =>
                array(
                    'name'        => 'Jane',
                    'lastName'    => 'Doe',
                    'gender'      => 'f',
                    'dateOfBirth' => '2001-01-01T00:11:22Z',
                ),
        ),
    'newsletter'        =>
        array(
            0 =>
                array(
                    'type'         => 'MyNewsletter',
                    'registeredAt' => '2001-01-01T00:11:22Z',
                ),
        ),
    'orders'            =>
        array(
            0 =>
                array(
                    'type'           => 'SomeProduct',
                    'orderID'        => '12345',
                    'orderValue'     => '46,33',
                    'orderDate'      => '2001-01-01T00:11:22Z',
                    'lifetimeValue'  => '123,12',
                    'purchaseDevice' => 'iPhone',
                    'discountName'   => 'DiscountName',
                    'discountValue'  => '10',
                    'categoryName0'  => 'A',
                    'categoryName1'  => 'B',
                    'categoryName3'  => 'C',
                    'paperFormat'    => 'A4',
                ),
        ),
    'optins'             =>
        array(
            0 =>
                array(
                    'type'        => 'marketing',
                    'id'          => '1234',
                    'text'        => 'I accept that...',
                    'doubleOptIn' => 'false',
                ),
        ),
    'terms'             =>
        array(
            0 =>
                array(
                    'type' => 'Privacy Policy',
                    'id'   => '1234',
                    'text' => 'I accept that....',
                ),
        ),
    'campaigns'         =>
        array(
            0 =>
                array(
                    'name'         => '',
                    'registeredAt' => '2001-01-01T00:11:22Z',
                ),
        ),
    'appUsage'          => '',
    'milestone'         => 'SomeMilestone',
);

try {
    /**
     * Encrypt and push data as array
     */
    $result = GujDataPushProvider::encryptAndPushArray($data);

    var_dump($result);
} catch (GujDataPushException $e) {

    var_dump($e->getMessage());
}