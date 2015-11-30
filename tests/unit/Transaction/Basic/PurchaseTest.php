<?php
namespace CedricBlondeau\Moneris\Tests\Transaction\Basic;

use CedricBlondeau\Moneris\Config;
use CedricBlondeau\Moneris\Transaction\Basic\Purchase;

final class PurchaseTest extends \PHPUnit_Framework_TestCase
{
    public function testGetXml()
    {
        $config = $this->getTestConfig();
        $params = $this->getPurchaseParams();
        $purchaseTransaction = new Purchase($config, $params);
        $xml = $purchaseTransaction->getXml();
        $this->assertEquals($config->getApiKey(), (string) $xml->api_token);
        $this->assertEquals($config->getStoreId(), (string) $xml->store_id);
        $this->assertTrue(isset($xml->purchase));
        $this->assertEquals($config->getCryptType(), (string) $xml->purchase->crypt_type);
        $this->assertEquals($params['order_id'], (string) $xml->purchase->order_id);
        $this->assertEquals($params['amount'], (string) $xml->purchase->amount);
        $this->assertEquals($params['cc_number'], (string) $xml->purchase->pan);
    }

    private function getTestConfig()
    {
        $config = new Config('test_api_key', 'store1');
        $config->setEnvironment(Config::ENV_TESTING);
        return $config;
    }

    private function getPurchaseParams()
    {
        return array(
            'cc_number' => '4242424242424242',
            'expiry_month' => 10,
            'expiry_year' => 18,
            'order_id' => 'test' . date("dmy-G:i:s"),
            'amount' => 100
        );
    }
}