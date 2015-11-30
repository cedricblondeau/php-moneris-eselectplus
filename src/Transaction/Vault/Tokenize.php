<?php
namespace CedricBlondeau\Moneris\Transaction\Vault;

use CedricBlondeau\Moneris\Config;
use CedricBlondeau\Moneris\Transaction\AbstractTransaction;

final class Tokenize extends AbstractTransaction
{
    /**
     * @param Config $config
     * @param array $params
     */
    public function __construct(Config $config, array $params)
    {
        parent::__construct('res_add_token', $config, $params);
        $this->requiredParams = array('data_key', 'expdate');
    }
}