<?php

use Guj\DataPush\Exception\GujDataPushException;
use Guj\DataPush\Model\Child;
use Guj\DataPush\Model\Order;
use Guj\DataPush\Model\PushData;
use Guj\DataPush\Model\UserData;
use Guj\DataPush\Provider\GujAwsSqsProvider;
use Guj\DataPush\Provider\GujDataPushProvider;
use Guj\DataPush\Provider\GujEncryptionProvider;

class GujDataPushProviderTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    /**
     * Ensure correct behavoir and exception handling
     */
    public function testInit()
    {
        $this->assertNull(GujDataPushProvider::$GUJ_DATAPUSH_BASE_PATH);
        $this->assertNull(GujDataPushProvider::$GUJ_DATAPUSH_SRC_PATH);
        $this->assertNull(GujDataPushProvider::$GUJ_DATAPUSH_RESOURCE_PATH);

        // get static properties/its values and check against null
        $awsProviderProperty = new \ReflectionProperty(GujDataPushProvider::class, 'awsProvider');
        $awsProviderProperty->setAccessible(true);
        $encryptionProviderProperty = new \ReflectionProperty(GujDataPushProvider::class, 'encryptionProvider');
        $encryptionProviderProperty->setAccessible(true);
        $this->assertNull($awsProviderProperty->getValue());
        $this->assertNull($encryptionProviderProperty->getValue());

        // call init and check properties afterwards
        GujDataPushProvider::init(
            array(
                'aws_sqs_region'     => 'SampleRegion',
                'aws_sqs_queue_name' => 'SampleQueue',
                'aws_sqs_key'        => 'SampleKey',
                'aws_sqs_secret'     => 'SampleSecret'
            )
        );

        $this->assertNotNull(GujDataPushProvider::$GUJ_DATAPUSH_BASE_PATH);
        $this->assertNotNull(GujDataPushProvider::$GUJ_DATAPUSH_SRC_PATH);
        $this->assertNotNull(GujDataPushProvider::$GUJ_DATAPUSH_RESOURCE_PATH);

        // build reflection-properties to protected static property values
        $awsProviderProperty = new \ReflectionProperty(GujDataPushProvider::class, 'awsProvider');
        $awsProviderProperty->setAccessible(true);

        $encryptionProviderProperty = new \ReflectionProperty(GujDataPushProvider::class, 'encryptionProvider');
        $encryptionProviderProperty->setAccessible(true);

        $this->assertInstanceOf(GujAwsSqsProvider::class, $awsProviderProperty->getValue());
        $this->assertInstanceOf(GujEncryptionProvider::class, $encryptionProviderProperty->getValue());
    }

    /**
     * Ensure correct behavoir and exception handling
     */
    public function testEncryptAndPushArray()
    {

        // create custom stub
        /** @var GujDataPushProvider $dataPushProviderStub */
        $dataPushProviderStub = \Codeception\Util\Stub::make(
            GujDataPushProvider::class,
            []
        );
        /** @var GujAwsSqsProvider $awsProviderStub */
        $awsProviderStub = \Codeception\Util\Stub::make(
            GujAwsSqsProvider::class,
            [
                'push' => function ($version, $client, $producer, $encrypted) {
                    return [$version, $client, $producer, $encrypted];
                },
            ]
        );
        /** @var GujEncryptionProvider $encryptionProviderStub */
        $encryptionProviderStub = \Codeception\Util\Stub::make(
            GujEncryptionProvider::class,
            [
                'encrypt' => function ($data_string) {
                    return [$data_string];
                },
            ]
        );

        // attach provider stubs to object
        $dataPushProviderStub::setAwsProvider($awsProviderStub);
        $dataPushProviderStub::setEncryptionProvider($encryptionProviderStub);

        $exspectedException = new GujDataPushException("Input format must be array", GujDataPushException::DATAPUSH_EXCEPTION_CODE);
        $this->tester->expectException(
            $exspectedException,
            function () use ($dataPushProviderStub) {
                $dataPushProviderStub::encryptAndPushArray("I'm not an array");
            }
        );

        $exspectedException = new GujDataPushException("\"client\"-key not found in data array.", GujDataPushException::DATAPUSH_EXCEPTION_CODE);
        $this->tester->expectException(
            $exspectedException,
            function () use ($dataPushProviderStub) {
                $dataPushProviderStub::encryptAndPushArray([]);
            }
        );

        $exspectedException = new GujDataPushException("\"producer\"-key not found in data array.", GujDataPushException::DATAPUSH_EXCEPTION_CODE);
        $this->tester->expectException(
            $exspectedException,
            function () use ($dataPushProviderStub) {
                $dataPushProviderStub::encryptAndPushArray(['client' => 'SampleClient']);
            }
        );

        $encryptAndPushStringParymeters = $dataPushProviderStub::encryptAndPushArray(['client' => 'SampleClient', 'producer' => 'SampleProducer', 'data' => 'SampleData']);
        $this->assertEquals("1.0.0", $encryptAndPushStringParymeters[0]);
        $this->assertEquals("SampleClient", $encryptAndPushStringParymeters[1]);
        $this->assertEquals("SampleProducer", $encryptAndPushStringParymeters[2]);
        $this->assertEquals(['{"client":"SampleClient","producer":"SampleProducer","data":"SampleData","version":"1.0.0"}'], $encryptAndPushStringParymeters[3]);

        $encryptAndPushStringParymeters = $dataPushProviderStub::encryptAndPushArray(['version' => '2.1.3', 'client' => 'SampleClient', 'producer' => 'SampleProducer', 'data' => 'SampleData']);
        $this->assertEquals("2.1.3", $encryptAndPushStringParymeters[0]);
    }

    /**
     * Test encryptAndPushObject
     */
    public function testEncryptAndPushObject()
    {
        // create custom stub
        /** @var GujDataPushProvider $dataPushProviderStub */
        $dataPushProviderStub = \Codeception\Util\Stub::make(
            GujDataPushProvider::class,
            []
        );
        /** @var GujAwsSqsProvider $awsProviderStub */
        $awsProviderStub = \Codeception\Util\Stub::make(
            GujAwsSqsProvider::class,
            [
                'push' => function ($version, $client, $producer, $encrypted) {
                    return [$version, $client, $producer, $encrypted];
                },
            ]
        );
        /** @var GujEncryptionProvider $encryptionProviderStub */
        $encryptionProviderStub = \Codeception\Util\Stub::make(
            GujEncryptionProvider::class,
            [
                'encrypt' => function ($data_string) {
                    return [$data_string];
                },
            ]
        );

        // attach provider stubs to object
        $dataPushProviderStub::setAwsProvider($awsProviderStub);
        $dataPushProviderStub::setEncryptionProvider($encryptionProviderStub);

        // create test data objects
        $pushData = new PushData();
        $pushData->setProducer('SampleProducer');
        $pushData->setClient('SampleClient');
        $pushData->setType('TestType');
        $pushData->setCreatedAt('01.01.2017 00:00:00');
        $pushData->setMilestone('SomeMilestone');

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
        $pushData->setUserData($userData);

        $child = new Child();
        $child->setName('Jane');
        $child->setLastName('Doe');
        $child->setGender('f');
        $child->setDateOfBirth('01.01.2001');
        $pushData->addChild($child);

        $order = new Order();
        $order->setOrderId("12345");
        $order->setOrderValue("46,33");
        $order->setPaperFormat('A4');
        $order->setOrderDate('01.01.2001');
        $order->setType('Something');
        $pushData->addOrder($order);

        $encryptAndPushStringParymeters = $dataPushProviderStub::encryptAndPushObject($pushData);

        $this->assertEquals("1.0.0", $encryptAndPushStringParymeters[0]);
        $this->assertEquals("SampleClient", $encryptAndPushStringParymeters[1]);
        $this->assertEquals("SampleProducer", $encryptAndPushStringParymeters[2]);
        $jsonString = '{"version":"1.0.0","producer":"SampleProducer","client":"SampleClient","type":"TestType","createdAt":"2017-01-01T00:00:00Z","appUsage":null,"milestone":"SomeMilestone","userData":{"ssoId":123456789,"customerNo":null,"userName":null,"name":"John","lastName":"Doe","gender":null,"dateOfBirth":"01.01.1950","email":"mail@example.com","phone":null,"mobile":null,"company":null,"street":"Teststreet","streetNo":"1","careOf":null,"postcode":12345,"city":"SampleCity","country":null},"children":[{"name":"Jane","lastName":"Doe","gender":"f","dateOfBirth":"01.01.2001"}],"newsletter":[],"orders":[{"type":"Something","orderId":"12345","orderDate":"01.01.2001","orderValue":"46,33","lifetimeValue":null,"purchaseDevice":null,"discountName":null,"discountValue":null,"categoryName0":null,"categoryName1":null,"categoryName3":null,"paperFormat":"A4"}],"optins":[],"terms":[],"campaigns":[]}';
        $this->assertEquals([$jsonString], $encryptAndPushStringParymeters[3]);
    }
}