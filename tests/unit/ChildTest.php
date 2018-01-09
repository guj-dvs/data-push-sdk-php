<?php

use Guj\DataPush\Model\Child;

class ChildTest extends \Codeception\Test\Unit
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
        $this->tester->wantToTest('Getters and Setters of Child model');
        $child = new Child();
        $child->setName('John');
        $child->setLastName('Doe');
        $child->setDateOfBirth('01.01.2000');
        $child->setGender('m');
        // get private properties to test them
        $properties = $this->tester->getPrivatePropertiesValueByReflection($child);

        $this->assertEquals('John', $properties['name']);
        $this->assertEquals('Doe', $properties['lastName']);
        $this->assertEquals('01.01.2000', $properties['dateOfBirth']);
        $this->assertEquals('m', $properties['gender']);
    }

    /**
     * Test json conversion
     */
    public function testToJson()
    {
        $child = new Child();
        $child->setName('John');
        $child->setLastName('Doe');
        $child->setDateOfBirth('01.01.2000');
        $child->setGender('m');
        $this->assertEquals('{"name":"John","lastName":"Doe","gender":"m","dateOfBirth":"01.01.2000"}', $child->toJSON());
    }
}