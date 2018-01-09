<?php

use Guj\DataPush\Model\OptIn;

class OptInTest extends \Codeception\Test\Unit
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
        $optIn = new OptIn();
        $optIn->setId(1);
        $optIn->setType('SampleType');
        $optIn->setDoubleOptIn(false);
        $optIn->setText('Lorem ipsum dolor sit amet');

        $properties = $this->tester->getPrivatePropertiesValueByReflection($optIn);
        $this->assertEquals(1, $properties['id']);
        $this->assertEquals('SampleType', $properties['type']);
        $this->assertEquals(false, $properties['doubleOptIn']);
        $this->assertEquals('Lorem ipsum dolor sit amet', $properties['text']);
    }

    /**
     * Test json conversion
     */
    public function testToJson()
    {
        $optIn = new OptIn();
        $optIn->setId(1);
        $optIn->setType('SampleType');
        $optIn->setDoubleOptIn(false);
        $optIn->setText('Lorem ipsum dolor sit amet');
        $this->assertEquals('{"type":"SampleType","id":1,"text":"Lorem ipsum dolor sit amet","doubleOptIn":false}', $optIn->toJSON());
    }

}