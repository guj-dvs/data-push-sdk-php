<?php

use Guj\DataPush\Model\Term;

class TermTest extends \Codeception\Test\Unit
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
        $this->tester->wantToTest('Getters and Setters of Term model');
        $term = new Term();
        $term->setId(1);
        $term->setType('SampleType');
        $term->setText('Lorem ipsum dolor sit amet');

        $properties = $this->tester->getPrivatePropertiesValueByReflection($term);
        $this->assertEquals(1, $properties['id']);
        $this->assertEquals('SampleType', $properties['type']);
        $this->assertEquals('Lorem ipsum dolor sit amet', $properties['text']);
    }

    /**
     * Test json conversion
     */
    public function testToJson()
    {
        $term = new Term();
        $term->setId(1);
        $term->setType('SampleType');
        $term->setText('Lorem ipsum dolor sit amet');
        $this->assertEquals('{"type":"SampleType","id":1,"text":"Lorem ipsum dolor sit amet"}', $term->toJSON());
    }

}