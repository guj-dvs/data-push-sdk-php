<?php

namespace Guj\DataPush\Provider;

use Guj\DataPush\Exception\GujDataPushException;
use Guj\DataPush\Model\PushData;

/**
 * Main provider for data push
 *
 * @package Guj\DataPush\Provider
 */
class GujDataPushProvider extends ConfigureableProvider
{
    /**  */
    const CONFIG_NAMESPACE = 'general';
    /** @var  GujAwsSqsProvider */
    protected static $awsProvider;
    /** @var  GujEncryptionProvider */
    protected static $encryptionProvider;
    public static $GUJ_DATAPUSH_BASE_PATH;
    public static $GUJ_DATAPUSH_SRC_PATH;
    public static $GUJ_DATAPUSH_RESOURCE_PATH;

    /**
     * @param GujAwsSqsProvider $awsProvider
     */
    public static function setAwsProvider(GujAwsSqsProvider $awsProvider)
    {
        self::$awsProvider = $awsProvider;
    }

    /**
     * @param GujEncryptionProvider $encryptionProvider
     */
    public static function setEncryptionProvider(GujEncryptionProvider $encryptionProvider)
    {
        self::$encryptionProvider = $encryptionProvider;
    }

    /**
     * Init datapush prodier and configure child providers
     *
     * @param array $config
     *
     * @throws GujDataPushException
     */
    public static function init(array $config)
    {
        self::setAwsProvider(new GujAwsSqsProvider());
        self::setEncryptionProvider(new GujEncryptionProvider());

        self::$awsProvider->configure($config);
        self::$encryptionProvider->configure($config);

        self::$GUJ_DATAPUSH_BASE_PATH = dirname(__FILE__) . "/../../";
        self::$GUJ_DATAPUSH_SRC_PATH = self::$GUJ_DATAPUSH_BASE_PATH . "/src";
        self::$GUJ_DATAPUSH_RESOURCE_PATH = self::$GUJ_DATAPUSH_SRC_PATH . "/Resources";
    }

    /**
     * Provide object of type PushData with data to encrypt and push.
     *
     * @param PushData $data
     *
     * @return bool
     * @throws GujDataPushException
     */
    public static function encryptAndPushObject(PushData $data)
    {
        return self::encryptAndPushString($data->getVersion(), $data->getClient(), $data->getProducer(), $data->toJSON());
    }

    /**
     * Provide array of data to encrypt and push.
     *
     * @param array $data
     *
     * @return bool
     * @throws GujDataPushException
     */
    public static function encryptAndPushArray($data)
    {
        if (!is_array($data)) {
            throw new GujDataPushException("Input format must be array", GujDataPushException::DATAPUSH_EXCEPTION_CODE);
        }
        if (!isset($data['version'])) {
            $data['version'] = PushData::DEFAULT_VERSION;
        }
        if (!isset($data['client'])) {
            throw new GujDataPushException("\"client\"-key not found in data array.", GujDataPushException::DATAPUSH_EXCEPTION_CODE);
        }
        if (!isset($data['producer'])) {
            throw new GujDataPushException("\"producer\"-key not found in data array.", GujDataPushException::DATAPUSH_EXCEPTION_CODE);
        }

        return self::encryptAndPushString($data['version'], $data['client'], $data['producer'], json_encode($data));
    }

    /**
     * Encrypt and push string
     *
     * @param string $version
     * @param string $client
     * @param string $producer
     * @param string $data_string
     *
     * @return bool
     */
    private static function encryptAndPushString($version, $client, $producer, $data_string)
    {
        $encrypted = self::$encryptionProvider->encrypt($data_string);

        return self::$awsProvider->push($version, $client, $producer, $encrypted);
    }

}