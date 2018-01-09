<?php

use Codeception\Util\Stub;
use Guj\DataPush\Exception\GujDataPushException;
use Guj\DataPush\Provider\ConfigureableProvider;

class ConfigureableProviderTest extends \Codeception\Test\Unit
{

    /**
     * @var \UnitTester
     */
    protected $tester;

    /**
     * Test getConfigValue to ensure correct behavior of ConfigurableProvider's data
     */
    public function testGetConfigValue()
    {
        $configProviderStub = Stub::make(
            ConfigureableProvider::class,
            array()
        );

        // build reflection class to call private/protected methods
        $reflector = new \ReflectionClass($configProviderStub);
        // get private/protected method to call
        $configMethod = $reflector->getMethod('configure');
        // change accessability
        $configMethod->setAccessible(true);
        // configure provider
        $configMethod->invokeArgs($configProviderStub, [['SampleKey' => 'SampleValue']]);
        // get private/protected method to call
        $getConfigValueMethod = $reflector->getMethod('getConfigValue');
        // change accessability
        $getConfigValueMethod->setAccessible(true);
        // invoke method and assert
        $configValue = $getConfigValueMethod->invokeArgs($configProviderStub, ['SampleKey']);
        $this->assertEquals('SampleValue', $configValue);
        // invoke method and assert
        $configValue = $getConfigValueMethod->invokeArgs($configProviderStub, ['NotExistentKey', 'DefaultValue']);
        $this->assertEquals('DefaultValue', $configValue);
        // invoke method and test exception handling
        $exspectedException = new GujDataPushException('ConfigValue not found', GujDataPushException::UNDEFINED_EXCEPTION_CODE, null);
        $this->tester->expectException(
            $exspectedException,
            function () use ($getConfigValueMethod, $configProviderStub) {
                $getConfigValueMethod->invokeArgs($configProviderStub, ['NotExistentKey']);
            }
        );
    }

    /**
     * Test IssetInConfig to ensure correct behavior of ConfigurableProvider's data
     */
    public function testIssetInConfig()
    {
        $configProviderStub = Stub::make(
            ConfigureableProvider::class,
            array()
        );

        // build reflection class to call private/protected methods
        $reflector = new \ReflectionClass($configProviderStub);
        // get private/protected method to call
        $configMethod = $reflector->getMethod('configure');
        // change accessability
        $configMethod->setAccessible(true);
        // configure provider
        $configMethod->invokeArgs($configProviderStub, [['SampleKey' => 'SampleValue']]);
        // get private/protected method to call
        $getConfigValueMethod = $reflector->getMethod('issetInConfig');
        // change accessability
        $getConfigValueMethod->setAccessible(true);
        // invoke method and assert
        $valueIsset = $getConfigValueMethod->invokeArgs($configProviderStub, ['SampleKey']);
        $this->assertEquals(true, $valueIsset);
        // invoke method and assert
        $valueIsset = $getConfigValueMethod->invokeArgs($configProviderStub, ['NotExistentKey']);
        $this->assertEquals(false, $valueIsset);
    }
}