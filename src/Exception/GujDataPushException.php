<?php

namespace Guj\DataPush\Exception;

/**
 * Global Exception-Class to handle all occurring exceptions and bundle them to one specific type.
 *
 * @package Guj\DataPush\Exception
 */
class GujDataPushException extends \Exception
{
    /**
     * AWS Exception Codes
     */
    const AWS_EXCEPTION_CODE     = 1000;
    const AWS_SQS_EXCEPTION_CODE = 1001;

    /**
     * Encryption Exception Codes
     */
    const ENCRYPTION_EXCEPTION_CODE = 2000;

    /**
     * DataPush Exception Codes
     */
    const DATAPUSH_EXCEPTION_CODE = 3000;

    /**
     * Validation Exception Code
     */
    const VALIDATION_EXCEPTION_CODE = 4000;

    /**
     * Undefined Exception Code
     */
    const UNDEFINED_EXCEPTION_CODE = -1000;

    /** @var \Exception */
    private $originalException;

    /**
     * Get the original exception thrown before
     *
     * @return \Exception
     */
    public function getOriginalException()
    {
        return $this->originalException;
    }

    /**
     * Set original exception to remeber the original one
     *
     * @param \Exception $originalException
     */
    public function setOriginalException($originalException)
    {
        $this->originalException = $originalException;
    }
}