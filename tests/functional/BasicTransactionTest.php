<?php
namespace CedricBlondeau\Moneris\Tests\Func;

use CedricBlondeau\Moneris\Http\Client\Curl;
use CedricBlondeau\Moneris\Transaction\Basic\Purchase;

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
            $curl = new Curl($transaction);
            $result = $curl->execute();
            $xml = simplexml_load_string($result);
            $this->assertEquals("027", $xml->receipt->ResponseCode);
        }
    }
}