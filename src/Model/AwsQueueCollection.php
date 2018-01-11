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
    private $standardQueue;
    /**
     * @var AwsQueue
     */
    private $errorQueue;
    /**
     * @var AwsQueue
     */
    private $fatalQueue;

    /**
     * AwsQueueCollection constructor.
     */
    public function __construct()
    {
        $this->standardQueue = new AwsQueue();
        $this->errorQueue = new AwsQueue();
        $this->fatalQueue = new AwsQueue();
    }

    /**
     * Get standard queue
     *
     * @return AwsQueue
     */
    public function getStandardQueue()
    {
        return $this->standardQueue;
    }

    /**
     * Get Error queue
     *
     * @return AwsQueue
     */
    public function getErrorQueue()
    {
        return $this->errorQueue;
    }

    /**
     * Get fatal queue
     *
     * @return AwsQueue
     */
    public function getFatalQueue()
    {
        return $this->fatalQueue;
    }
}