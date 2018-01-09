<?php

use Guj\DataPush\Model\Campaign;
use Guj\DataPush\Model\Child;
use Guj\DataPush\Model\Newsletter;
use Guj\DataPush\Model\OptIn;
use Guj\DataPush\Model\Order;
use Guj\DataPush\Model\PushData;
use Guj\DataPush\Model\Term;
use Guj\DataPush\Model\UserData;

class PushDataTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    /**
     * Test getters and setters
     */
    public function testGetterAndSetters()
    {
        $this->tester->wantToTest('Getters and Setters of OptIn model');
        $pushData = new PushData();
        $pushData->setType('SampleType');
        $pushData->setMilestone('SampleMilestone');
        $pushData->setProducer('SampleProducer');
        $pushData->setUserData(new UserData());
        $pushData->setCreatedAt('01.01.2017 00:00:00');
        $pushData->setClient('SampleClient');
        $pushData->setVersion('1.0');
        $pushData->setAppUsage('SampleUsage');
        $pushData->setCampaigns(array());
        $pushData->setChildren(array());
        $pushData->setNewsletter(array());
        $pushData->setOptins(array());
        $pushData->setOrders(array());
        $pushData->setTerms(array());

        $properties = $this->tester->getPrivatePropertiesValueByReflection($pushData);
        $this->assertEquals('SampleType', $properties['type']);
        $this->assertEquals('SampleMilestone', $properties['milestone']);
        $this->assertEquals('SampleProducer', $properties['producer']);
        $this->assertEquals('SampleProducer', $pushData->getProducer());
        $this->assertInstanceOf('\Guj\DataPush\Model\UserData', $properties['userData']);
        $this->assertEquals('2017-01-01T00:00:00Z', $properties['createdAt']);
        $this->assertEquals('SampleClient', $properties['client']);
        $this->assertEquals('SampleClient', $pushData->getClient());
        $this->assertEquals('1.0', $properties['version']);
        $this->assertEquals('1.0', $pushData->getVersion());
        $this->assertEquals('SampleUsage', $properties['appUsage']);
        $this->assertEquals(array(), $properties['campaigns']);
        $this->assertEquals(array(), $properties['children']);
        $this->assertEquals(array(), $properties['newsletter']);
        $this->assertEquals(array(), $properties['optins']);
        $this->assertEquals(array(), $properties['orders']);
        $this->assertEquals(array(), $properties['terms']);

        $pushData->addOrder(new Order());
        $pushData->addChild(new Child());
        $pushData->addCampaign(new Campaign());
        $pushData->addNewsletter(new Newsletter());
        $pushData->addOptIn(new OptIn());
        $pushData->addTerm(new Term());
        $properties = $this->tester->getPrivatePropertiesValueByReflection($pushData);
        $this->assertEquals(array(new Order()), $properties['orders']);
        $this->assertEquals(array(new Child()), $properties['children']);
        $this->assertEquals(array(new Campaign()), $properties['campaigns']);
        $this->assertEquals(array(new Newsletter()), $properties['newsletter']);
        $this->assertEquals(array(new OptIn()), $properties['optins']);
        $this->assertEquals(array(new Term()), $properties['terms']);
    }

    /**
     * Test json conversion
     */
    public function testToJson()
    {
        $pushData = new PushData();
        $pushData->setType('SampleType');
        $pushData->setMilestone('SampleMilestone');
        $pushData->setProducer('SampleProducer');
        $pushData->setUserData(new UserData());
        $pushData->setCreatedAt('01.01.2017 00:00:00');
        $pushData->setClient('SampleClient');
        $pushData->setVersion('1.0');
        $pushData->setAppUsage('SampleUsage');
        $pushData->setCampaigns(array());
        $pushData->setChildren(array());
        $pushData->setNewsletter(array());
        $pushData->setOptins(array());
        $pushData->setOrders(array());
        $pushData->setTerms(array());
        $pushData->addOrder(new Order());
        $pushData->addChild(new Child());
        $pushData->addCampaign(new Campaign());
        $pushData->addNewsletter(new Newsletter());
        $pushData->addOptIn(new OptIn());
        $pushData->addTerm(new Term());
        $this->assertEquals(
            '{"version":"1.0","producer":"SampleProducer","client":"SampleClient","type":"SampleType","createdAt":"2017-01-01T00:00:00Z","appUsage":"SampleUsage","milestone":"SampleMilestone","userData":{"ssoId":null,"customerNo":null,"userName":null,"name":null,"lastName":null,"gender":null,"dateOfBirth":null,"email":null,"phone":null,"mobile":null,"company":null,"street":null,"streetNo":null,"careOf":null,"postcode":null,"city":null,"country":null},"children":[{"name":null,"lastName":null,"gender":null,"dateOfBirth":null}],"newsletter":[{"type":null,"registeredAt":null}],"orders":[{"type":null,"orderId":null,"orderDate":null,"orderValue":null,"lifetimeValue":null,"purchaseDevice":null,"discountName":null,"discountValue":null,"categoryName0":null,"categoryName1":null,"categoryName3":null,"paperFormat":null}],"optins":[{"type":null,"id":null,"text":null,"doubleOptIn":null}],"terms":[{"type":null,"id":null,"text":null}],"campaigns":[{"name":null,"registeredAt":null}]}',
            $pushData->toJSON()
        );
    }

}