<?php

namespace Guj\DataPush\Provider;

use Guj\DataPush\Exception\GujDataPushException;

/**
 * Abstract class to provide inheriting classes emthods for setting and getting class-specific configuration-values
 *
 * @package Guj\DataPush\Provider
 */
abstract class ConfigureableProvider
{
    /**
     * @var string
     */
    const CONFIG_NAMESPACE = "";
    /**
     * @var array
     */
    protected $config = array();

    /**
     * @param  mixed $configKey
     * @param mixed  $defaultValue (optional)
     *
     * @return mixed|null
     * @throws GujDataPushException
     */
    protected function getConfigValue($configKey, $defaultValue = null)
    {
        if (isset($this->config[$configKey])) {
            return $this->config[$configKey];
        } elseif ($defaultValue !== null) {
            return $defaultValue;
        } else {
            throw new GujDataPushException('ConfigValue not found', GujDataPushException::UNDEFINED_EXCEPTION_CODE, null);
        }
    }

    /**
     * Check if specific configuration value exists for current class
     *
     * @param $configKey
     *
     * @return mixed
     */
    protected function issetInConfig($configKey)
    {
        return isset($this->config[$configKey]);
    }

    /**
     * Apply inherited class specific configuration values from array. Only values starting with value from "self::CONFIG_NAMESPACE" getting stored.
     *
     * @param array $config
     */
    protected function configure(array $config)
    {
        foreach ($config as $key => $value) {
            if (substr($key, 0, strlen(static::CONFIG_NAMESPACE)) == static::CONFIG_NAMESPACE) {
                $newKey = str_replace(static::CONFIG_NAMESPACE . "_", "", $key);
                $this->config[$newKey] = $value;
            }
        }
    }

}