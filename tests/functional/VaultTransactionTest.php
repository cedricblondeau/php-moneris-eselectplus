<?php
namespace CedricBlondeau\Moneris\Tests\Func;

use CedricBlondeau\Moneris\Http\Client\Curl;
use CedricBlondeau\Moneris\Transaction\AbstractTransaction;
use CedricBlondeau\Moneris\Transaction\Vault\PreAuth;

final class VaultTransactionTest extends BaseTest
{
    public function testPreAuth()
    {
        $transaction = new PreAuth($this->getConfig(), array(
            'data_key' => 'ZsEFBiNqeHy4we9JVt1n6Dft4',
            'expiry_month' => 10,
            'expiry_year' => 18,
            'order_id' => 'test' . date("dmy-G:i:s"),
            'amount' => 100
        ));
        $errors = $transaction->validate();
        $this->assertEquals(0, count($errors));
        if (count($errors) == 0) {
            $xml = $this->getCurlResponse($transaction);
            $this->assertEquals("027", $xml->receipt->ResponseCode);
        }
    }

    private function getCurlResponse(AbstractTransaction $transaction)
    {
        $curl = new Curl($transaction);
        $result = $curl->execute();
        $xml = simplexml_load_string($result);
        return $xml;
    }
}