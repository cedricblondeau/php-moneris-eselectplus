<?php
namespace CedricBlondeau\Moneris\Http\Client;

use CedricBlondeau\Moneris\Http\Client;

/**
 * Dummy implementation of HTTP client.
 * Useful for unit testing Http\AbstractClient.
 *
 * @package CedricBlondeau\Moneris\Http\Client
 */
final class Dummy extends AbstractClient implements Client
{
    /**
     * @return mixed
     */
    public function execute()
    {
        return false;
    }
}