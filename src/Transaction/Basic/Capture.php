<?php
namespace CedricBlondeau\Moneris\Transaction\Basic;

use CedricBlondeau\Moneris\Config;
use CedricBlondeau\Moneris\Transaction\AbstractTransaction;

final class Capture extends AbstractTransaction
{
    /**
     * @param Config $config
     * @param array $params
     */
    public function __construct(Config $config, array $params)
    {
        parent::__construct('completion', $config, $params);
        $this->requiredParams = array('comp_amount', 'order_id', 'txn_number');
    }

    /**
     * Force order for this transaction (!)
     *
     * @return array
     */
    public function validate()
    {
        $errors = parent::validate();
        if (count($errors) == 0) {
            $this->params = array(
                'order_id' => $this->params['order_id'],
                'comp_amount' => $this->params['comp_amount'],
                'txn_number' => $this->params['txn_number']
            );
        }
        return $errors;
    }
}