<?php

require dirname(__FILE__) . "/../vendor/autoload.php";

use Guj\DataPush\Exception\GujDataPushException;
use Guj\DataPush\Model\Child;
use Guj\DataPush\Model\Order;
use Guj\DataPush\Model\PushData;
use Guj\DataPush\Model\UserData;
use Guj\DataPush\Provider\GujDataPushProvider;

GujDataPushProvider::init(
    array(
        // 'aws_sqs_region'      => 'eu-west-1', // default value
        'aws_sqs_queue_name' => '[[ QUEUE_NAME ]]',
        'aws_sqs_key'        => '[[ AWS_KEY ]]',
        'aws_sqs_secret'     => '[[ AWS_SECRET ]]',
    )
);

/**
 * Create PushData
 */
$data = new PushData();
$data->setProducer('TestProducer');
$data->setClient('TestClient');
$data->setType('TestType');
$data->setCreatedAt(time());
$data->setMilestone('SomeMilestone');

/**
 * USERDATA
 */
$userData = new UserData();
$userData->setSsoId(123456789);
$userData->setDateOfBirth('01.01.1950');
$userData->setName('John');
$userData->setLastName('Doe');
$userData->setEmail('mail@example.com');
$userData->setCity('SampleCity');
$userData->setPostcode(12345);
$userData->setStreet('Teststreet');
$userData->setStreetNo('1');

$data->setUserData($userData);

/**
 * CHILDREN
 */
$child = new Child();
$child->setName('Jane');
$child->setLastName('Doe');
$child->setGender('f');
$child->setDateOfBirth('01.01.2001');

$data->addChild($child);

/**
 * ORDERS
 */
$order = new Order();
$order->setOrderId("12345");
$order->setOrderValue("46,33");
$order->setPaperFormat('A4');
$order->setOrderDate('01.01.2001');
$order->setType('Something');

$data->addOrder($order);

try {
    /**
     * Encrypt and push data
     */
    $result = GujDataPushProvider::encryptAndPushObject($data);

    var_dump($result);
} catch (GujDataPushException $e) {

    var_dump($e->getMessage());
}
