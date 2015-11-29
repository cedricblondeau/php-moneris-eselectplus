<?php
namespace CedricBlondeau\Moneris\Transaction;

use CedricBlondeau\Moneris\Config;

abstract class AbstractTransaction
{
    /**
     * @var Config
     */
    private $config;

    /**
     * @var array
     */
    private $params;

    /**
     * @var array
     */
    protected $requiredParams = array();

    /**
     * @param $type
     * @param Config $config
     * @param array $params
     */
    protected function __construct($type, Config $config, array $params)
    {
        $this->config = $config;
        $params['type'] = $type;
        $this->params = $this->prepare($params);
    }

    /**
     * @return Config
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * Clean up transaction parameters.
     *
     * @param array $params
     * @return array Cleaned up parameters
     */
    private function prepare(array $params)
    {
        foreach ($params as $k => $v) {
            // remove whitespace
            if (is_string($v)) {
                $params[$k] = trim($v);
            }

            // remove optional params
            if ('' == $params[$k]) {
                unset($params[$k]);
            }
        }

        // amount has to include a penny value, or the transaction will fail:
        if (isset($params['amount']) && false === strpos($params['amount'], '.')) {
            $params['amount'] .= '.00';
        }

        if (isset($params['cc_number'])) {
            $params['pan'] = preg_replace('/\D/', '', $params['cc_number']);
            unset($params['cc_number']);
        }

        if (isset($params['description'])) {
            $params['dynamic_descriptor'] = $params['description'];
            unset($params['description']);
        }

        if (isset($params['expiry_month']) && isset($params['expiry_year']) && ! isset($params['expdate'])) {
            $params['expdate'] = sprintf('%02d%02d', $params['expiry_year'], $params['expiry_month']);
            unset($params['expiry_year'], $params['expiry_month']);
        }

        return $params;
    }

    /**
     * @return array
     */
    public function validate()
    {
        $errors = array();
        foreach ($this->requiredParams as $requiredParam) {
            if (!isset($this->params[$requiredParam])) {
                $errors[] = "{$requiredParam} is required.";
            }
        }
        return $errors;
    }

    /**
     * @return \SimpleXMLElement
     */
    public function getXml()
    {
        $request_type = in_array($this->params['type'], array('txn', 'acs')) ? 'MpiRequest' : 'request';
        $xml = new \SimpleXMLElement("<$request_type/>");
        $xml->addChild('store_id', $this->config->getStoreId());
        $xml->addChild('api_token', $this->config->getApiKey());
        $type = $xml->addChild($this->params['type']);
        $type->addChild('crypt_type', $this->config->getCryptType());
        foreach ($this->params as $key => $value) {
            if ($key != 'type') {
                $type->addChild($key, $value);
            }
        }
        return $xml;
    }
}