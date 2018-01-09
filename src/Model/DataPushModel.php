<?php

namespace Guj\DataPush\Model;

use Guj\DataPush\Exception\GujDataPushException;

/**
 * Baseclass for Dataobjects
 *
 * @package Guj\DataPush\Model
 */
class DataPushModel implements \JsonSerializable
{
    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return get_object_vars($this);
    }

    /**
     * @return string
     */
    public function toJSON()
    {
        return json_encode($this);
    }

    /**
     * Convert datestring or timestamp to specific formated datestring
     *
     * @param int|string $value    datestring or timestamp
     * @param bool       $withTime return result with time in GM-Format
     *
     * @return string
     * @throws GujDataPushException
     */
    public function convertToDate($value, $withTime = true)
    {
        if (!is_int($value)) {
            $timestamp = strtotime($value);
        } else {
            $timestamp = $value;
        }
        if (!$withTime && $timestamp !== false) {
            $value = date('d.m.Y', $timestamp);
        } else {
            if (!is_int($timestamp)) {
                throw new GujDataPushException("Unable to convert datestring/timestamp", GujDataPushException::VALIDATION_EXCEPTION_CODE);
            }
            $value = gmdate("Y-m-d\TH:i:s\Z", $timestamp);
        }

        return $value;
    }
}