<?php

namespace Guj\DataPush\Provider;

use Guj\DataPush\Exception\GujDataPushException;

/**
 * Encrypt string with asymetric PGP
 *
 * @package Guj\DataPush\Provider
 */
class GujEncryptionProvider extends ConfigureableProvider
{
    /** filename for public key file  */
    const PUBLIC_KEY_FILE = 'public.key.php';
    /** namepsace / prefix for configuration values */
    const CONFIG_NAMESPACE = 'encryption';

    /**
     * Encrypt string with PGP and configured public key
     *
     * @param string $unencryptedData
     *
     * @return string
     *s
     * @throws GujDataPushException
     */
    public function encrypt($unencryptedData)
    {
        $asciiPublicKey = $this->readPublicKey();
        /**
         *
         * Using this https://github.com/jasonhinkle/php-gpg because the
         */
        $gpg = new \GPG();
        // create an instance of a GPG public key object based on ASCII key
        $pub_key = new \GPG_Public_Key($asciiPublicKey);
        // using the key, encrypt your plain text using the public key
        $encrypted = $gpg->encrypt($pub_key, $unencryptedData, "GujDataService");

        return $encrypted;
    }

    /**
     * Read public key file and skip first line of php protection for preventing public access
     *
     * @return string public key file content
     */
    protected function readPublicKey()
    {
        $lines = file(GujDataPushProvider::$GUJ_DATAPUSH_RESOURCE_PATH . '/' . self::PUBLIC_KEY_FILE);
        unset($lines[0]);
        $publicKey = implode('', $lines);

        return $publicKey;
    }
}