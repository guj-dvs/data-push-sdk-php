<?php

use Guj\DataPush\Model\UserData;

class UserDataTest extends \Codeception\Test\Unit
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
        $this->tester->wantToTest('Getters and Setters of UserData model');
        $userData = new UserData();
        $userData->setName('SampleName');
        $userData->setLastName('SampleLastName');
        $userData->setDateOfBirth('01.01.2000');
        $userData->setStreet('SampleStreet');
        $userData->setStreetNo('11a');
        $userData->setCity('SampleCity');
        $userData->setPostcode('12345');
        $userData->setEmail('sample@email.com');
        $userData->setSsoId('123456789');
        $userData->setCareOf('SampleCareOf');
        $userData->setCompany('SampleCompany');
        $userData->setCustomerNo('987654321');
        $userData->setGender('m');
        $userData->setCountry('SampleCountry');
        $userData->setMobile('01234/456789');
        $userData->setPhone('04321/987654');
        $userData->setUserName('SampleUsername');

        $properties = $this->tester->getPrivatePropertiesValueByReflection($userData);
        $this->assertEquals('SampleName', $properties['name']);
        $this->assertEquals('SampleLastName', $properties['lastName']);
        $this->assertEquals('01.01.2000', $properties['dateOfBirth']);
        $this->assertEquals('SampleStreet', $properties['street']);
        $this->assertEquals('11a', $properties['streetNo']);
        $this->assertEquals('SampleCity', $properties['city']);
        $this->assertEquals('12345', $properties['postcode']);
        $this->assertEquals('sample@email.com', $properties['email']);
        $this->assertEquals('123456789', $properties['ssoId']);
        $this->assertEquals('SampleCareOf', $properties['careOf']);
        $this->assertEquals('SampleCompany', $properties['company']);
        $this->assertEquals('987654321', $properties['customerNo']);
        $this->assertEquals('m', $properties['gender']);
        $this->assertEquals('SampleCountry', $properties['country']);
        $this->assertEquals('01234/456789', $properties['mobile']);
        $this->assertEquals('04321/987654', $properties['phone']);
        $this->assertEquals('SampleUsername', $properties['userName']);
    }

    /**
     * Test json conversion
     */
    public function testToJson()
    {
        $userData = new UserData();
        $userData->setName('SampleName');
        $userData->setLastName('SampleLastName');
        $userData->setDateOfBirth('01.01.2000');
        $userData->setStreet('SampleStreet');
        $userData->setStreetNo('11a');
        $userData->setCity('SampleCity');
        $userData->setPostcode('12345');
        $userData->setEmail('sample@email.com');
        $userData->setSsoId('123456789');
        $userData->setCareOf('SampleCareOf');
        $userData->setCompany('SampleCompany');
        $userData->setCustomerNo('987654321');
        $userData->setGender('m');
        $userData->setCountry('SampleCountry');
        $userData->setMobile('01234/456789');
        $userData->setPhone('04321/987654');
        $userData->setUserName('SampleUsername');

        $this->assertEquals('{"ssoId":"123456789","customerNo":"987654321","userName":"SampleUsername","name":"SampleName","lastName":"SampleLastName","gender":"m","dateOfBirth":"01.01.2000","email":"sample@email.com","phone":"04321\/987654","mobile":"01234\/456789","company":"SampleCompany","street":"SampleStreet","streetNo":"11a","careOf":"SampleCareOf","postcode":"12345","city":"SampleCity","country":"SampleCountry"}', $userData->toJSON());
    }

}