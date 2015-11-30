<?php
namespace CedricBlondeau\Moneris\Transaction\Basic;

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
        parent::__construct('preauth', $config, $params);
        $this->requiredParams = array('order_id', 'pan', 'amount', 'expdate');
    }
}