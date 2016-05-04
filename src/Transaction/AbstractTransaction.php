<?php
namespace CedricBlondeau\Moneris\Transaction;

use CedricBlondeau\Moneris\Config;

abstract class AbstractTransaction
{
    /**
     * @var string
     */
    private $type;

    /**
     * @var Config
     */
    private $config;

    /**
     * @var array
     */
    protected $params;

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
        $this->type = $type;
        $this->config = $config;
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

        // Amount has to include a penny value, or the transaction will fail
        if (isset($params['amount']) && false === strpos($params['amount'], '.')) {
            $params['amount'] .= '.00';
        }
        if (isset($params['comp_amount']) && false === strpos($params['comp_amount'], '.')) {
            $params['comp_amount'] .= '.00';
        }

        if (isset($params['cc_number'])) {
            $params['pan'] = preg_replace('/\D/', '', $params['cc_number']);
            unset($params['cc_number']);
        }

        if (isset($params['description'])) {
            $params['dynamic_descriptor'] = $params['description'];
            unset($params['description']);
        }

        // Build expdate from expiry_month/expiry_year
        if (isset($params['expiry_month']) && isset($params['expiry_year']) && ! isset($params['expdate'])) {
            if (strlen($params['expiry_year']) == 4) $params['expiry_year'] = substr($params['expiry_year'], 2, 2);
            $params['expdate'] = sprintf('%02d%02d', $params['expiry_year'], $params['expiry_month']);
            unset($params['expiry_year'], $params['expiry_month']);
        }

        return $params;
    }

    /**
     * Make sure all parameters are passed
     *
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
        $request_type = in_array($this->type, array('txn', 'acs')) ? 'MpiRequest' : 'request';
        $xml = new \SimpleXMLElement("<$request_type/>");
        $xml->addChild('store_id', $this->config->getStoreId());
        $xml->addChild('api_token', $this->config->getApiKey());
        $type = $xml->addChild($this->type);
        foreach ($this->params as $key => $value) {
            $type->addChild($key, $value);
        }
        $type->addChild('crypt_type', $this->config->getCryptType());
        return $xml;
    }
}