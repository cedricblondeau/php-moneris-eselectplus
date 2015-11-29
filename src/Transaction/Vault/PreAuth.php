<?php
namespace CedricBlondeau\Moneris\Transaction\Vault;

use CedricBlondeau\Moneris\Config;
use CedricBlondeau\Moneris\Transaction\AbstractTransaction;

final class PreAuth extends AbstractTransaction
{
    /**
     * @param Config $config
     * @param array $params
     */
    public function __construct(Config $config, array $params)
    {
        parent::__construct('res_preauth_cc', $config, $params);
        $this->requiredParams = array('order_id', 'data_key', 'amount', 'expdate');
    }
}