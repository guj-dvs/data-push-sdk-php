<?php

namespace Guj\DataPush\Model;

/**
 * OptIn model
 *
 * @package Guj\DataPush\Model
 */
class OptIn extends DataPushModel
{
    /**
     * @var string
     */
    protected $type;
    /**
     * @var string
     */
    protected $id;
    /**
     * @var string
     */
    protected $text;
    /**
     * @var bool
     */
    protected $doubleOptIn;

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @param string $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @param string $text
     */
    public function setText($text)
    {
        $this->text = $text;
    }

    /**
     * @param bool $doubleOptIn
     */
    public function setDoubleOptIn($doubleOptIn)
    {
        $this->doubleOptIn = (bool)$doubleOptIn;
    }

}