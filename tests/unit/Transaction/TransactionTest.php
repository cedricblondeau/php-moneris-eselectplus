<?php
namespace CedricBlondeau\Moneris\Tests;

use CedricBlondeau\Moneris\Transaction\AbstractTransaction;
use CedricBlondeau\Moneris\Config;

final class DummyTestTransaction extends AbstractTransaction
{
    /**
     * @param Config $config
     */
    public function __construct(Config $config)
    {
        parent::__construct('dummy_test', $config, array());
        $this->requiredParams = array();
    }
}

final class CcTestTransaction extends AbstractTransaction
{
    /**
     * @param Config $config
     * @param array $params
     */
    public function __construct(Config $config, array $params)
    {
        parent::__construct('cc_test', $config, $params);
        $this->requiredParams = array('pan', 'exp_date');
    }
}

final class TransactionTest extends \PHPUnit_Framework_TestCase
{
    public function testApiKeyAndStoreId()
    {
        $config = $this->getTestConfig();
        $transaction = new DummyTestTransaction($config);
        $xml = $transaction->getXml();
        $this->assertEquals($config->getApiKey(), (string) $xml->api_token);
        $this->assertEquals($config->getStoreId(), (string) $xml->store_id);
    }

    public function testRequiredParameters()
    {
        $transaction = new CcTestTransaction($this->getTestConfig(), array());
        $errors = $transaction->validate();
        $this->assertEquals(2, count($errors));
    }

    public function testFullCreditCardExpirationDate()
    {
        $pan = '4242424242424242';
        $expdate = '1910';
        $transaction = new CcTestTransaction($this->getTestConfig(), array(
            'pan' => $pan,
            'expdate' => $expdate
        ));
        $xml = $transaction->getXml();
        $this->assertTrue(isset($xml->cc_test));
        $this->assertEquals($pan, (string) $xml->cc_test->pan);
        $this->assertEquals($expdate, (string) $xml->cc_test->expdate);
    }

    public function testComposedCreditCardExpirationDate()
    {
        $expdate = '2112';
        $transaction = new CcTestTransaction($this->getTestConfig(), array(
            'expiry_year' => 2021,
            'expiry_month' => 12
        ));
        $xml = $transaction->getXml();
        $this->assertTrue(isset($xml->cc_test));
        $this->assertEquals($expdate, (string) $xml->cc_test->expdate);
    }

    private function getTestConfig()
    {
        $config = new Config('test_api_key', 'store1');
        $config->setEnvironment(Config::ENV_TESTING);
        return $config;
    }
}