<?php
namespace CedricBlondeau\Moneris\Tests\Func;

use CedricBlondeau\Moneris\Config;

abstract class BaseTest extends \PHPUnit_Framework_TestCase
{
    protected function getConfig()
    {
        return new Config(array(
            'api_key' => 'yesguy',
            'store_id' => 'store1',
            'environment' => Config::ENV_TESTING
        ));
    }
}