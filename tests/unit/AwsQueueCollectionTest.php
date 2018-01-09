<?php

class AwsQueueCollectionTest extends \Codeception\Test\Unit
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
        $this->tester->wantToTest('Getters and Setters of AwsQueueCollection model');

        $awsQueueCollection = new \Guj\DataPush\Model\AwsQueueCollection();
        $this->assertInstanceOf('\Guj\DataPush\Model\AwsQueue', $awsQueueCollection->getStandard());
        $this->assertInstanceOf('\Guj\DataPush\Model\AwsQueue', $awsQueueCollection->getFatal());
        $this->assertInstanceOf('\Guj\DataPush\Model\AwsQueue', $awsQueueCollection->getError());
    }
}