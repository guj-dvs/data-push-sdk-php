<?php

use Guj\DataPush\Model\Order;

class OrderTest extends \Codeception\Test\Unit
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
        $this->tester->wantToTest('Getters and Setters of Order model');
        $order = new Order();
        $order->setType('SampleType');
        $order->setOrderDate('01.01.2017');
        $order->setPaperFormat('A4');
        $order->setOrderValue('99.95');
        $order->setCategoryName0('SampleCategory0');
        $order->setCategoryName1('SampleCategory1');
        $order->setCategoryName3('SampleCategory3');
        $order->setDiscountName('SampleDiscount');
        $order->setDiscountValue('9.95');
        $order->setLifetimeValue('SampleValue');
        $order->setOrderId('0815');
        $order->setPurchaseDevice('SampleDevice');

        $properties = $this->tester->getPrivatePropertiesValueByReflection($order);
        $this->assertEquals('SampleType', $properties['type']);
        $this->assertEquals('01.01.2017', $properties['orderDate']);
        $this->assertEquals('A4', $properties['paperFormat']);
        $this->assertEquals('99.95', $properties['orderValue']);
        $this->assertEquals('SampleCategory0', $properties['categoryName0']);
        $this->assertEquals('SampleCategory1', $properties['categoryName1']);
        $this->assertEquals('SampleCategory3', $properties['categoryName3']);
        $this->assertEquals('SampleDiscount', $properties['discountName']);
        $this->assertEquals('9.95', $properties['discountValue']);
        $this->assertEquals('SampleValue', $properties['lifetimeValue']);
        $this->assertEquals('0815', $properties['orderId']);
        $this->assertEquals('SampleDevice', $properties['purchaseDevice']);
    }

    /**
     * Test json conversion
     */
    public function testToJson()
    {
        $order = new Order();
        $order->setType('SampleType');
        $order->setOrderDate('01.01.2017');
        $order->setPaperFormat('A4');
        $order->setOrderValue('99.95');
        $order->setCategoryName0('SampleCategory0');
        $order->setCategoryName1('SampleCategory1');
        $order->setCategoryName3('SampleCategory3');
        $order->setDiscountName('SampleDiscount');
        $order->setDiscountValue('9.95');
        $order->setLifetimeValue('SampleValue');
        $order->setOrderId('0815');
        $order->setPurchaseDevice('SampleDevice');
        $this->assertEquals('{"type":"SampleType","orderId":"0815","orderDate":"01.01.2017","orderValue":"99.95","lifetimeValue":"SampleValue","purchaseDevice":"SampleDevice","discountName":"SampleDiscount","discountValue":"9.95","categoryName0":"SampleCategory0","categoryName1":"SampleCategory1","categoryName3":"SampleCategory3","paperFormat":"A4"}', $order->toJSON());
    }

}