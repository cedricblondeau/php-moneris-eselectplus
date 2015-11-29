<?php
namespace CedricBlondeau\Moneris\Http;

use CedricBlondeau\Moneris\Transaction\AbstractTransaction;

interface Client
{
    /**
     * @param AbstractTransaction $transaction
     */
    public function __construct(AbstractTransaction $transaction);

    /**
     * @return mixed
     */
    public function execute();
}