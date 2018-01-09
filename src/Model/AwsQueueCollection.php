<?php

namespace Guj\DataPush\Model;

/**
 * Set of aws queues matching standard, error and fatal pattern
 *
 * @package Guj\DataPush\Model
 */
class AwsQueueCollection
{
    const QUEUE_TYPE_STANDARD = 'standard';
    const QUEUE_TYPE_ERROR    = 'error';
    const QUEUE_TYPE_FATAL    = 'fatal';

    /**
     * @var AwsQueue
     */
    private $standard;
    /**
     * @var AwsQueue
     */
    private $error;
    /**
     * @var AwsQueue
     */
    private $fatal;

    /**
     * AwsQueueCollection constructor.
     */
    public function __construct()
    {
        $this->standard = new AwsQueue();
        $this->error = new AwsQueue();
        $this->fatal = new AwsQueue();
    }

    /**
     * Get standard queue params
     *
     * @return AwsQueue
     */
    public function getStandard()
    {
        return $this->standard;
    }

    /**
     * Get Error queue params
     *
     * @return AwsQueue
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * Get fatal queue params
     *
     * @return AwsQueue
     */
    public function getFatal()
    {
        return $this->fatal;
    }
}