<?php
namespace CedricBlondeau\Moneris;

/**
 * Moneris configuration class
 *
 * @package CedricBlondeau\Moneris
 */
final class Config
{
    const ENV_LIVE = 'live'; // use the live API server
    const ENV_STAGING = 'staging'; // use the API sandbox
    const ENV_TESTING = 'testing'; // use the mock API

    /**
     * @var string
     */
    private $apiKey;

    /**
     * @var string
     */
    private $storeId;

    /**
     * @var string
     */
    private $environment = self::ENV_LIVE;

    /**
     * @var array
     */
    private $cvdCodes = array('M', 'Y', 'P', 'S', 'U');

    /**
     * @var array
     */
    private $avsCodes = array('A','B', 'D', 'M', 'P', 'W', 'X', 'Y', 'Z');

    /**
     * @var boolean
     */
    private $requireAvs = false;

    /**
     * @var boolean
     */
    private $requireCvd = false;

    /**
     * @var int
     */
    private $cryptType = 7; // SSL enabled merchant


    /**
     * @param $apiKey
     * @param $storeId
     */
    public function __construct($apiKey, $storeId)
    {
        $this->setApiKey($apiKey);
        $this->setStoreId($storeId);
    }

    /**
     * @return string
     */
    public function getApiKey()
    {
        return $this->apiKey;
    }

    /**
     * @param string $apiKey
     */
    private function setApiKey($apiKey)
    {
        $this->apiKey = $apiKey;
    }

    /**
     * @return int
     */
    public function getStoreId()
    {
        return $this->storeId;
    }

    /**
     * @param int $storeId
     */
    private function setStoreId($storeId)
    {
        $this->storeId = $storeId;
    }

    /**
     * @return string
     */
    public function getEnvironment()
    {
        return $this->environment;
    }

    /**
     * @param string $environment
     */
    public function setEnvironment($environment)
    {
        if (in_array($environment, array(self::ENV_LIVE, self::ENV_STAGING, self::ENV_TESTING)))
        {
            $this->environment = $environment;
        }
    }

    /**
     * @return array
     */
    public function getCvdCodes()
    {
        return $this->cvdCodes;
    }

    /**
     * @param array $cvdCodes
     */
    public function setCvdCodes(array $cvdCodes)
    {
        $this->cvdCodes = $cvdCodes;
    }

    /**
     * @return array
     */
    public function getAvsCodes()
    {
        return $this->avsCodes;
    }

    /**
     * @param array $avsCodes
     */
    public function setAvsCodes(array $avsCodes)
    {
        $this->avsCodes = $avsCodes;
    }

    /**
     * @return boolean
     */
    public function isRequireAvs()
    {
        return $this->requireAvs;
    }

    /**
     * @param boolean $requireAvs
     */
    public function setRequireAvs($requireAvs)
    {
        $this->requireAvs = $requireAvs;
    }

    /**
     * @return boolean
     */
    public function isRequireCvd()
    {
        return $this->requireCvd;
    }

    /**
     * @param boolean $requireCvd
     */
    public function setRequireCvd($requireCvd)
    {
        $this->requireCvd = $requireCvd;
    }

    /**
     * @return int
     */
    public function getCryptType()
    {
        return $this->cryptType;
    }

    /**
     * @param int $cryptType
     */
    public function setCryptType($cryptType)
    {
        if (is_int($cryptType) && $cryptType >= 1 && $cryptType <= 7)
        {
            $this->cryptType = $cryptType;
        }
    }
}