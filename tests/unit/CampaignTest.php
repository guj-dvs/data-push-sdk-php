<?php

use Guj\DataPush\Model\Campaign;

class CampaignTest extends \Codeception\Test\Unit
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
        $this->tester->wantToTest('Getters and Setters of Campaign model');
        $campaign = new Campaign();
        $campaign->setName('SampleName');
        $timestamp = mktime(0, 0, 1, 1, 1, 2017);
        $campaign->setRegisteredAt($timestamp);

        $properties = $this->tester->getPrivatePropertiesValueByReflection($campaign);
        $this->assertEquals('SampleName', $properties['name']);
        $this->assertEquals(gmdate("Y-m-d\TH:i:s\Z", $timestamp), $properties['registeredAt']);
    }

    /**
     * Test json conversion
     */
    public function testToJson()
    {
        $campaign = new Campaign();
        $campaign->setName('SampleName');
        $timestamp = mktime(0, 0, 1, 1, 1, 2017);
        $campaign->setRegisteredAt($timestamp);
        $this->assertEquals('{"name":"SampleName","registeredAt":"2017-01-01T00:00:01Z"}', $campaign->toJSON());
    }

}