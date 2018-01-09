<?php

namespace Guj\DataPush\Model;

/**
 * Child model
 *
 * @package Guj\DataPush\Model
 */
class Child extends DataPushModel
{
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
     * @param string|int $dateOfBirth Date-String or Unix-Timestamp
     */
    public function setDateOfBirth($dateOfBirth)
    {
        $this->dateOfBirth = $this->convertToDate($dateOfBirth, false);
    }
}