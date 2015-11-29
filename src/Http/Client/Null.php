<?php
namespace CedricBlondeau\Moneris\Http\Client;

use CedricBlondeau\Moneris\Http\Client;

/**
 * Null implementation of HTTP client
 *
 * @package CedricBlondeau\Moneris\Http\Client
 */
final class Null extends AbstractClient implements Client
{
    /**
     * @return mixed
     */
    public function execute()
    {
        return false;
    }
}