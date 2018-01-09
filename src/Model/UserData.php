<?php

namespace Guj\DataPush\Model;

/**
 * UserData model
 *
 * @package Guj\DataPush\Model
 */
class UserData extends DataPushModel
{
    /**
     * @var string
     */
    protected $ssoId;
    /**
     * @var string
     */
    protected $customerNo;
    /**
     * @var string
     */
    protected $userName;
    /**
     * @var string
     */
    protected $name;
    /**
     * @var string
     */
    protected $lastName;
    /**
     * @var string
     */
    protected $gender;
    /**
     * @var string
     */
    protected $dateOfBirth;
    /**
     * @var string
     */
    protected $email;
    /**
     * @var string
     */
    protected $phone;
    /**
     * @var string
     */
    protected $mobile;
    /**
     * @var string
     */
    protected $company;
    /**
     * @var string
     */
    protected $street;
    /**
     * @var string
     */
    protected $streetNo;
    /**
     * @var string
     */
    protected $careOf;
    /**
     * @var string
     */
    protected $postcode;
    /**
     * @var string
     */
    protected $city;
    /**
     * @var string
     */
    protected $country;

    /**
     * @param string $ssoId
     */
    public function setSsoId($ssoId)
    {
        $this->ssoId = $ssoId;
    }

    /**
     * @param string $customerNo
     */
    public function setCustomerNo($customerNo)
    {
        $this->customerNo = $customerNo;
    }

    /**
     * @param string $userName
     */
    public function setUserName($userName)
    {
        $this->userName = $userName;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @param string $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    /**
     * @param string $gender
     */
    public function setGender($gender)
    {
        $this->gender = $gender;
    }

    /**
     * @param string $dateOfBirth
     */
    public function setDateOfBirth($dateOfBirth)
    {
        $this->dateOfBirth = $this->convertToDate($dateOfBirth, false);
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @param string $phone
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    /**
     * @param string $mobile
     */
    public function setMobile($mobile)
    {
        $this->mobile = $mobile;
    }

    /**
     * @param string $company
     */
    public function setCompany($company)
    {
        $this->company = $company;
    }

    /**
     * @param string $street
     */
    public function setStreet($street)
    {
        $this->street = $street;
    }

    /**
     * @param string $streetNo
     */
    public function setStreetNo($streetNo)
    {
        $this->streetNo = $streetNo;
    }

    /**
     * @param string $careOf
     */
    public function setCareOf($careOf)
    {
        $this->careOf = $careOf;
    }

    /**
     * @param string $postcode
     */
    public function setPostcode($postcode)
    {
        $this->postcode = $postcode;
    }

    /**
     * @param string $city
     */
    public function setCity($city)
    {
        $this->city = $city;
    }

    /**
     * @param string $country
     */
    public function setCountry($country)
    {
        $this->country = $country;
    }

}