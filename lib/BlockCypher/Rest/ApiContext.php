<?php

namespace BlockCypher\Rest;

use BlockCypher\Auth\TokenCredential;
use BlockCypher\Core\BlockCypherCoinSymbolConstants;
use BlockCypher\Core\BlockCypherConfigManager;
use BlockCypher\Core\BlockCypherCredentialManager;
use BlockCypher\Exception\BlockCypherConfigurationException;

/**
 * Class ApiContext
 *
 * Call level parameters such as request id, credentials etc
 *
 * @package BlockCypher\Rest
 */
class ApiContext
{
    /**
     * Default ApiContext when no ApiContext is provided as param.
     * @var ApiContext
     */
    public static $defaultApiContext = null;

    /**
     * This is a placeholder for holding credential for the request
     * If the value is not set, it would get the value from @\BlockCypher\Core\BlockCypherCredentialManager
     *
     * @var \BlockCypher\Auth\SimpleTokenCredential
     */
    protected $credential;

    /**
     * main|test|test3
     * @var string
     */
    protected $chain;

    /**
     * btc|doge|ltc|uro|bcy
     * @var string
     */
    protected $coin;

    /**
     * v1
     * @var string
     */
    protected $version;

    /**
     * Unique request id to be used for this call
     * The user can either generate one as per application
     * needs or let the SDK generate one
     *
     * @var null|string $requestId
     */
    protected $requestId;

    /**
     * Construct
     *
     * @param TokenCredential $credential
     * @param string|null $chain
     * @param string|null $coin
     * @param string|null $version
     * @param string|null $requestId
     */
    public function __construct(
        $credential = null,
        $chain = 'main',
        $coin = 'btc',
        $version = 'v1',
        $requestId = null
    )
    {
        $this->credential = $credential;
        $this->chain = $chain;
        $this->coin = $coin;
        $this->version = $version;
        $this->requestId = $requestId;
    }

    /**
     * Create new default ApiContext.
     *
     * @param string $chain
     * @param string $coin
     * @param string $version
     * @param TokenCredential $credential
     * @param array|null $config
     * @param string $blockCypherPartnerAttributionId
     * @return ApiContext
     * @throws BlockCypherConfigurationException
     */
    public static function create(
        $chain = 'main',
        $coin = 'btc',
        $version = 'v1',
        $credential = null,
        $config = null,
        $blockCypherPartnerAttributionId = null)
    {
        // ### Api context
        // Use an ApiContext object to authenticate
        // API calls. The Token for the
        // SimpleTokenCredential class can be retrieved from
        // https://accounts.blockcypher.com/

        $apiContext = new ApiContext($credential, $chain, $coin, $version);

        if (is_array($config)) {
            $apiContext->setConfig($config);
        } else {
            // BC_CONFIG_PATH should be defined
            if (!defined("BC_CONFIG_PATH")) {
                throw new BlockCypherConfigurationException('BC_CONFIG_PATH should be defined with the path of sdk_config.ini file if no config array is given');
            }
        }

        // Partner Attribution Id. For the time being it is not used.
        if ($blockCypherPartnerAttributionId !== null) {
            $apiContext->addRequestHeader('BlockCypher-Partner-Attribution-Id', $blockCypherPartnerAttributionId);
        }

        return $apiContext;
    }

    /**
     * Sets Config
     *
     * @param array $config SDK configuration parameters
     */
    public function setConfig(array $config)
    {
        BlockCypherConfigManager::getInstance()->addConfigs($config);
    }

    public function addRequestHeader($name, $value)
    {
        // Determine if the name already has a 'http.headers' prefix. If not, add one.
        if (!(substr($name, 0, strlen('http.headers')) === 'http.headers')) {
            $name = 'http.headers.' . $name;
        }
        BlockCypherConfigManager::getInstance()->addConfigs(array($name => $value));
    }

    /**
     * @param ApiContext $apiContext
     * @return ApiContext
     */
    public static function setDefault($apiContext)
    {
        self::$defaultApiContext = $apiContext;
    }

    /**
     * Returns default ApiContext.
     *
     * @return ApiContext
     */
    public static function getDefault()
    {
        return self::$defaultApiContext;
    }

    /**
     * Get Credential
     *
     * @return \BlockCypher\Auth\SimpleTokenCredential
     */
    public function getCredential()
    {
        if ($this->credential == null) {
            return BlockCypherCredentialManager::getInstance()->getCredentialObject();
        }
        return $this->credential;
    }

    public function getRequestHeaders()
    {
        $result = BlockCypherConfigManager::getInstance()->get('http.headers');
        $headers = array();
        foreach ($result as $header => $value) {
            $headerName = ltrim($header, 'http.headers');
            $headers[$headerName] = $value;
        }
        return $headers;
    }

    /**
     * Resets the requestId that can be used to set the BlockCypher-request-id
     * header used for idempotency. In cases where you need to make multiple create calls
     * using the same ApiContext object, you need to reset request Id.
     *
     * @return string
     */
    public function resetRequestId()
    {
        $this->requestId = $this->generateRequestId();
        return $this->getRequestId();
    }

    /**
     * Generates a unique per request id that
     * can be used to set the BlockCypher-Request-Id header
     * that is used for idempotency
     *
     * @return string
     */
    private function generateRequestId()
    {
        static $pid = -1;
        static $addr = -1;

        if ($pid == -1) {
            $pid = getmypid();
        }

        if ($addr == -1) {
            if (array_key_exists('SERVER_ADDR', $_SERVER)) {
                $addr = ip2long($_SERVER['SERVER_ADDR']);
            } else {
                $addr = php_uname('n');
            }
        }

        return $addr . $pid . $_SERVER['REQUEST_TIME'] . mt_rand(0, 0xffff);
    }

    /**
     * Get Request ID
     *
     * @return string
     */
    public function getRequestId()
    {
        if ($this->requestId == null) {
            $this->requestId = $this->generateRequestId();
        }

        return $this->requestId;
    }

    /**
     * Gets Configurations
     *
     * @return array
     */
    public function getConfig()
    {
        return BlockCypherConfigManager::getInstance()->getConfigHashmap();
    }

    /**
     * Gets a specific configuration from key
     *
     * @param $searchKey
     * @return mixed
     */
    public function get($searchKey)
    {
        return BlockCypherConfigManager::getInstance()->get($searchKey);
    }

    /**
     * @return string
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * @param string $version
     * @return $this
     */
    public function setVersion($version)
    {
        $this->version = $version;
        return $this;
    }

    /**
     * @return string
     */
    public function getChain()
    {
        return $this->chain;
    }

    /**
     * @param string $chain
     * @return $this
     */
    public function setChain($chain)
    {
        $this->chain = $chain;
        return $this;
    }

    /**
     * @return string
     */
    public function getCoin()
    {
        return $this->coin;
    }

    /**
     * @param string $coin
     * @return $this
     */
    public function setCoin($coin)
    {
        $this->coin = $coin;
        return $this;
    }

    /**
     * @return string
     */
    public function getBaseChainUrl()
    {
        return "/{$this->version}/{$this->coin}/{$this->chain}";
    }

    /**
     * Map coin and chain to coin symbol
     * @return string
     */
    public function getCoinSymbol()
    {
        return BlockCypherCoinSymbolConstants::getCoinSymbolFrom($this->coin, $this->chain);
    }
}
