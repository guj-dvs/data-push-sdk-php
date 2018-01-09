<?php

namespace Guj\DataPush\Model;

/**
 * Newsletter model
 *
 * @package Guj\DataPush\Model
 */
class Newsletter extends DataPushModel
{
    /**
     * @var string
     */
    protected $type;
    /**
     * @var string
     */
    protected $registeredAt;

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @param string $registeredAt
     */
    public function setRegisteredAt($registeredAt)
    {
        $this->registeredAt = $this->convertToDate($registeredAt);;
    }
}