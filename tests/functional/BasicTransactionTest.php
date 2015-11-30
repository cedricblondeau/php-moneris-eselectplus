<?php
namespace CedricBlondeau\Moneris\Tests\Func;

use CedricBlondeau\Moneris\Http\Client\Curl;
use CedricBlondeau\Moneris\Transaction\AbstractTransaction;
use CedricBlondeau\Moneris\Transaction\Basic\Capture;
use CedricBlondeau\Moneris\Transaction\Basic\Purchase;
use CedricBlondeau\Moneris\Transaction\Basic\PreAuth;

final class BasicTransactionTest extends BaseTest
{
    public function testPurchase()
    {
        $transaction = new Purchase($this->getConfig(), array(
            'cc_number' => '4242424242424242',
            'expiry_month' => 10,
            'expiry_year' => 18,
            'order_id' => 'test' . date("dmy-G:i:s"),
            'amount' => 100
        ));
        $errors = $transaction->validate();
        $this->assertEquals(0, count($errors));
        if (count($errors) == 0) {
            $xml = $this->getCurlResponse($transaction);
            $this->assertNotNull($xml->receipt);
            $this->assertEquals("027", $xml->receipt->ResponseCode);
        }
    }

    public function testPreAuth()
    {
        $transaction = new PreAuth($this->getConfig(), array(
            'cc_number' => '5454545454545454',
            'expiry_month' => 10,
            'expiry_year' => 18,
            'order_id' => 'test' . date("dmy-G:i:s"),
            'amount' => 100
        ));
        $errors = $transaction->validate();
        $this->assertEquals(0, count($errors));
        if (count($errors) == 0) {
            $xml = $this->getCurlResponse($transaction);
            $this->assertNotNull($xml->receipt);
            $this->assertNotNull($xml->receipt->TransID);
            $this->assertEquals("027", $xml->receipt->ResponseCode);
            return $xml->receipt->TransID;
        }
    }

    /**
     * @param $transactionId
     * @depends testPreAuth
     */
    public function testCapture($transactionId)
    {
        if ($transactionId) {
            $transaction = new Capture($this->getConfig(), array(
                'txn_number' => $transactionId,
                'order_id' => 'test' . date("dmy-G:i:s"),
                'comp_amount' => 100
            ));
            $errors = $transaction->validate();
            $this->assertEquals(0, count($errors));
            if (count($errors) == 0) {
                $xml = $this->getCurlResponse($transaction);
            }
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