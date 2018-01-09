<?php
use Guj\DataPush\Provider\GujDataPushProvider;

class GujEncryptionProviderTest extends \Codeception\Test\Unit
{
    /**
     * @var \FunctionalTester
     */
    protected $tester;

    /**
     * Test string encryption with GPG
     */
    public function testEncryptString()
    {
        $this->tester->expectTo('get correct encrypted string from encrypt method');

        // define resource path to load public key from
        GujDataPushProvider::$GUJ_DATAPUSH_RESOURCE_PATH = dirname(__FILE__) . "/../../src/Resources";

        // create encryption provider and encrypt test string
        $encryptionProvider = new \Guj\DataPush\Provider\GujEncryptionProvider();
        $stringToEncrypt = "Hello World";
        $encryptedString = $encryptionProvider->encrypt($stringToEncrypt);

        // Validate encrypted message structure and length
        $this->assertContains('-----BEGIN PGP MESSAGE-----', $encryptedString);
        $this->assertContains('-----END PGP MESSAGE-----', $encryptedString);
        $this->assertContains('Version: GujDataService', $encryptedString);
        $this->assertEquals(902, strlen($encryptedString));

        // reset static var;
        GujDataPushProvider::$GUJ_DATAPUSH_RESOURCE_PATH = null;
    }
}