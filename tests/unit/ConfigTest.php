<?php
namespace CedricBlondeau\Moneris\Tests;

use CedricBlondeau\Moneris\Config;

final class ConfigTest extends \PHPUnit_Framework_TestCase
{
    public function testConstructor()
    {
        $apiKey = "test_api_key";
        $storeId = "my_custom_store";
        $config = new Config($apiKey, $storeId);
        $this->assertEquals($apiKey, $config->getApiKey());
        $this->assertEquals($storeId, $config->getStoreId());
        $this->assertEquals(Config::ENV_LIVE, $config->getEnvironment());
        $this->assertEquals(false, $config->isRequireAvs());
        $this->assertEquals(false, $config->isRequireCvd());
        $this->assertEquals(7, $config->getCryptType());
        return $config;
    }

    /**
     * @depends testConstructor
     * @param Config $config
     */
    public function testSetEnvironment(Config $config)
    {
        $environment = Config::ENV_STAGING;
        $config->setEnvironment($environment);
        $this->assertEquals($environment, $config->getEnvironment());
    }

    /**
     * @depends testConstructor
     * @param Config $config
     */
    public function testSetRequireAvs(Config $config)
    {
        $config->setRequireAvs(true);
        $this->assertEquals(true, $config->isRequireAvs());
    }

    /**
     * @depends testConstructor
     * @param Config $config
     */
    public function testSetRequireCvd(Config $config)
    {
        $config->setRequireCvd(true);
        $this->assertEquals(true, $config->isRequireCvd());
    }
}