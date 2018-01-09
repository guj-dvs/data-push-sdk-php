<?php

class AwsQueueTest extends \Codeception\Test\Unit
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
        $this->tester->wantToTest('Getters and Setters of AwsQueue model');

        $awsQueue = new \Guj\DataPush\Model\AwsQueue();
        $awsQueue->setArn('SampleARN');
        $awsQueue->setUrl('SampleURL');
        $this->assertEquals('SampleARN', $awsQueue->getArn());
        $this->assertEquals('SampleURL', $awsQueue->getURL());
    }
}