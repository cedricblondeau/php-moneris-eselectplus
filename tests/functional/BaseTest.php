<?php
namespace CedricBlondeau\Moneris\Tests\Func;

use CedricBlondeau\Moneris\Config;

abstract class BaseTest extends \PHPUnit_Framework_TestCase
{
    protected function getConfig()
    {
        $config = new Config('yesguy', 'store1');
        $config->setEnvironment(Config::ENV_TESTING);
        return $config;
    }
}