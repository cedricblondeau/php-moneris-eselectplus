<?php
namespace CedricBlondeau\Moneris\Tests;

use CedricBlondeau\Moneris\Config;

final class ConfigTest extends \PHPUnit_Framework_TestCase
{
    public function testFromArray()
    {
        $test_values = array(
            'api_key' => 'test_api_key',
            'store_id' => 99,
            'environment' => Config::ENV_TESTING
        );
        $config = new Config($test_values['api_key'], $test_values['store_id']);
        $config->setEnvironment($test_values['environment']);
        $this->assertEquals($test_values['api_key'], $config->getApiKey());
        $this->assertEquals($test_values['store_id'], $config->getStoreId());
        $this->assertEquals($test_values['environment'], $config->getEnvironment());
    }
}