<?php
namespace CedricBlondeau\Moneris\Tests\Http\Client;

use CedricBlondeau\Moneris\Config;
use CedricBlondeau\Moneris\Http\Client\Dummy;
use CedricBlondeau\Moneris\Transaction\Basic\Purchase;

final class DummyTest extends \PHPUnit_Framework_TestCase
{
    public function testLiveGetUrl()
    {
        $nullHttpClient = new Dummy($this->getPurchaseTransaction($this->getLiveConfig()));
        $url = parse_url($nullHttpClient->getUrl());
        $this->assertEquals("www3.moneris.com", $url['host']);
    }

    public function testStagingGetUrl()
    {
        $nullHttpClient = new Dummy($this->getPurchaseTransaction($this->getStagingConfig()));
        $url = parse_url($nullHttpClient->getUrl());
        $this->assertEquals("esqa.moneris.com", $url['host']);
    }

    private function getPurchaseTransaction(Config $config)
    {
        return new Purchase($config, array(
            'cc_number' => '4242424242424242',
            'expiry_month' => 10,
            'expiry_year' => 18,
            'order_id' => 'test' . date("dmy-G:i:s"),
            'amount' => 100
        ));
    }

    private function getLiveConfig()
    {
        $config = new Config('test_api_key', 'store1');
        $config->setEnvironment(Config::ENV_LIVE);
        return $config;
    }

    private function getStagingConfig()
    {
        $config = new Config('test_api_key', 'store2');
        $config->setEnvironment(Config::ENV_STAGING);
        return $config;
    }
}