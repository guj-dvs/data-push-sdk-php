<?php

namespace Guj\DataPush\Model;

/**
 * Campaign model
 *
 * @package Guj\DataPush\Model
 */
class Campaign extends DataPushModel
{
    /**
     * @var string
     */
    protected $name;
    /**
     * @var string
     */
    protected $registeredAt;

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @param int $registeredAt
     */
    public function setRegisteredAt(int $registeredAt)
    {
        $registeredAt = gmdate("Y-m-d\TH:i:s\Z", $registeredAt);
        $this->registeredAt = $registeredAt;
    }
}