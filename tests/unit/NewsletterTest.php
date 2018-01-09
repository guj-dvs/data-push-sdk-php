<?php

use Guj\DataPush\Model\Newsletter;

class NewsletterTest extends \Codeception\Test\Unit
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
        $this->tester->wantToTest('Getters and Setters of Newsletter model');
        $newsletter = new Newsletter();
        $newsletter->setType('SampleType');
        $timestamp = mktime(0, 0, 1, 1, 1, 2017);
        $newsletter->setRegisteredAt($timestamp);

        $properties = $this->tester->getPrivatePropertiesValueByReflection($newsletter);
        $this->assertEquals('SampleType', $properties['type']);
        $this->assertEquals(gmdate("Y-m-d\TH:i:s\Z", $timestamp), $properties['registeredAt']);
    }

    /**
     * Test json conversion
     */
    public function testToJson()
    {
        $newsletter = new Newsletter();
        $newsletter->setType('SampleType');
        $timestamp = mktime(0, 0, 1, 1, 1, 2017);
        $newsletter->setRegisteredAt($timestamp);
        $this->assertEquals('{"type":"SampleType","registeredAt":"2017-01-01T00:00:01Z"}', $newsletter->toJSON());
    }

}