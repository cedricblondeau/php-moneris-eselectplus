<?php
namespace CedricBlondeau\Moneris\Http\Client;

use CedricBlondeau\Moneris\Http\Client;
use CedricBlondeau\Moneris\Http\Config;
use CedricBlondeau\Moneris\Http\Transaction;

/**
 * CURL implementation of HTTP client
 *
 * @package CedricBlondeau\Moneris\Http\Client
 */
final class Curl extends AbstractClient implements Client
{
    /**
     * @return mixed
     */
    public function execute()
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->getUrl());
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $this->transaction->getXml()->asXML());
        curl_setopt($ch, CURLOPT_TIMEOUT, $this->config['timeout']);
        curl_setopt($ch, CURLOPT_USERAGENT, $this->config['api_version']);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    }
}