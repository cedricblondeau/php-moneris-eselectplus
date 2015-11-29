<?php
namespace CedricBlondeau\Moneris\Http\Client;

use CedricBlondeau\Moneris\Config;
use CedricBlondeau\Moneris\Transaction\AbstractTransaction;

abstract class AbstractClient
{
    /**
     * API config variables pulled from the terrible Moneris API.
     * @var array
     */
    protected $config = array(
        'protocol' => 'https',
        'host' => 'esqa.moneris.com',
        'port' => '443',
        'url' => '/gateway2/servlet/MpgRequest',
        'api_version' =>'PHP - 2.5.6',
        'timeout' => '60'
    );

    /**
     * @var Transaction
     */
    protected $transaction;

    /**
     * @param AbstractTransaction $transaction
     */
    public function __construct(AbstractTransaction $transaction)
    {
        $this->transaction = $transaction;
        if ($transaction->getConfig()->getEnvironment() == Config::ENV_LIVE) {
            $this->config['host'] = 'www3.moneris.com';
        }
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        $url = $this->config['protocol'] . '://' .
            $this->config['host'] . ':' .
            $this->config['port'] .
            $this->config['url'];
        return $url;
    }

}