<?php

namespace BlockCypher\Core;

use BlockCypher\Exception\BlockCypherConfigurationException;

/**
 * Class BlockCypherCoinSymbolConstants
 *
 * @package BlockCypher\Core
 */
class BlockCypherCoinSymbolConstants
{
    /**
     * List of Coin Symbol Ordered Dictionaries
     * @const array
     */
    protected static /** @noinspection SpellCheckingInspection */
        $COIN_SYMBOL_ODICT_LIST = array(
        array(
            'coin_symbol' => 'btc',
            'display_name' => 'Bitcoin',
            'display_shortname' => 'BTC',
            'blockcypher_code' => 'btc',
            'blockcypher_network' => 'main',
            'currency_abbrev' => 'BTC',
            'pow' => 'sha',
            'example_address' => '16Fg2yjwrbtC6fZp61EV9mNVKmwCzGasw5',
            "address_first_char_list" => array('1', '3')
        ),
        array(
            'coin_symbol' => 'btc-testnet',
            'display_name' => 'Bitcoin Testnet',
            'display_shortname' => 'BTC Testnet',
            'blockcypher_code' => 'btc',
            'blockcypher_network' => 'test3',
            'currency_abbrev' => 'BTC',
            'pow' => 'sha',
            'example_address' => '2N1rjhumXA3ephUQTDMfGhufxGQPZuZUTMk',
            "address_first_char_list" => array('m', 'n', '2')
        ),
        array(
            'coin_symbol' => 'ltc',
            'display_name' => 'Litecoin',
            'display_shortname' => 'LTC',
            'blockcypher_code' => 'ltc',
            'blockcypher_network' => 'main',
            'currency_abbrev' => 'LTC',
            'pow' => 'scrypt',
            'example_address' => 'LcFFkbRUrr8j7TMi8oXUnfR4GPsgcXDepo',
            "address_first_char_list" => array('L', 'U', '3')  // TODO: confirm
        ),
        array(
            'coin_symbol' => 'doge',
            'display_name' => 'Dogecoin',
            'display_shortname' => 'DOGE',
            'blockcypher_code' => 'doge',
            'blockcypher_network' => 'main',
            'currency_abbrev' => 'DOGE',
            'pow' => 'scrypt',
            'example_address' => 'D7Y55r6Yoc1G8EECxkQ6SuSjTgGJJ7M6yD',
            "address_first_char_list" => array('D', '9', 'A')
        ),
        array(
            'coin_symbol' => 'uro',
            'display_name' => 'Uro',
            'display_shortname' => 'URO',
            'blockcypher_code' => 'uro',
            'blockcypher_network' => 'main',
            'currency_abbrev' => 'URO',
            'pow' => 'sha',
            'example_address' => 'Uhf1LGdgmWe33hB9VVtubyzq1GduUAtaAJ',
            "address_first_char_list" => array('U')  // TODO: more?
        ),
        array(
            'coin_symbol' => 'bcy',
            'display_name' => 'BlockCypher Testnet',
            'display_shortname' => 'BC Testnet',
            'blockcypher_code' => 'bcy',
            'blockcypher_network' => 'test',
            'currency_abbrev' => 'BCY',
            'pow' => 'sha',
            'example_address' => 'CFr99841LyMkyX5ZTGepY58rjXJhyNGXHf',
            "address_first_char_list" => array('B', 'C', 'D')
        )
    );

    /**
     * Singleton Object
     *
     * @var $this
     */
    protected static $instance;

    /**
     * @const array
     */
    private static $REQUIRED_FIELDS = array(
        'coin_symbol', // this is a made up unique symbol for library use only
        'display_name', // what it commonly looks like
        'display_shortname', // an abbreviated version of display_name (for when space is tight)
        'blockcypher_code', // blockcypher's unique ID (for their URLs)
        'blockcypher_network', // the blockcypher network (main/test)
        'currency_abbrev', // what the unit of currency looks like when abbreviated
        'pow', // the proof of work algorithm (sha/scrypt)
        'example_address' // an example address
    );

    /**
     * @const array
     */
    private static $ELIGIBLE_POW_ENTRIES = array('sha', 'scrypt');

    /**
     * @const array
     */
    private $COIN_SYMBOL_MAPPINGS = array();

    /**
     * @const array
     */
    private $COIN_SYMBOL_LIST = array();

    /**
     * @const array
     */
    private $SHA_COINS = array();

    /**
     * @const array
     */
    private $SCRYPT_COINS = array();

    /**
     * @const array
     */
    private $COIN_CHOICES = array();

    /**
     * @const array
     */
    private $CHAIN_NAMES = array();

    /**
     * Private Constructor
     */
    public function __construct()
    {
        // Safety checks on the data
        $this->checkData();

        $this->initCoinSymbolMappings();
        $this->initCoinSymbolList();
        $this->initShaCoins();
        $this->initScryptCoins();
        $this->initCoinChoices();
        $this->initChainNames();
    }

    private function checkData()
    {
        foreach (static::COIN_SYMBOL_ODICT_LIST() as $coinSymbol) {

            // Make sure no required fields are missing
            foreach (static::REQUIRED_FIELDS() as $requiredField) {
                if (!isset($coinSymbol[$requiredField])) {
                    throw new BlockCypherConfigurationException("Missing required field $requiredField");
                }
            }

            // Make sure POW is set correctly
            if (!in_array($coinSymbol['pow'], static::ELIGIBLE_POW_ENTRIES())) {
                throw new BlockCypherConfigurationException("Invalid CoinSymbol POW " . $coinSymbol['pow'] . " in CoinSymbol " . $coinSymbol['coin_symbol']);
            }
        }
    }

    /**
     * @return array
     */
    public static function COIN_SYMBOL_ODICT_LIST()
    {
        return static::$COIN_SYMBOL_ODICT_LIST;
    }

    /**
     * @return array
     */
    public static function REQUIRED_FIELDS()
    {
        return self::$REQUIRED_FIELDS;
    }

    /**
     * @return array
     */
    public static function ELIGIBLE_POW_ENTRIES()
    {
        return self::$ELIGIBLE_POW_ENTRIES;
    }

    private function initCoinSymbolMappings()
    {
        $coinSymbolMappings = array();
        foreach (static::COIN_SYMBOL_ODICT_LIST() as $coinSymbolDict) {
            $coinSymbol = array_shift($coinSymbolDict);
            $coinSymbolMappings[$coinSymbol] = $coinSymbolDict;
        }
        $this->COIN_SYMBOL_MAPPINGS = $coinSymbolMappings;
    }

    private function initCoinSymbolList()
    {
        $coinSymbolList = array();
        foreach (static::COIN_SYMBOL_ODICT_LIST() as $x) {
            $coinSymbolList[] = $x['coin_symbol'];
        }
        $this->COIN_SYMBOL_LIST = $coinSymbolList;
    }

    private function initShaCoins()
    {
        $shaCoins = array();
        foreach (static::COIN_SYMBOL_ODICT_LIST() as $x) {
            if ($x['pow'] == 'sha') {
                $shaCoins[] = $x['coin_symbol'];
            }
        }
        $this->SHA_COINS = $shaCoins;
    }

    private function initScryptCoins()
    {
        $scryptCoins = array();
        foreach (static::COIN_SYMBOL_ODICT_LIST() as $x) {
            if ($x['pow'] == 'scrypt') {
                $scryptCoins[] = $x['coin_symbol'];
            }
        }
        $this->SCRYPT_COINS = $scryptCoins;
    }

    private function initCoinChoices()
    {
        $coinChoices = array();
        foreach (static::COIN_SYMBOL_ODICT_LIST() as $x) {
            $coinChoices[$x['coin_symbol']] = $x['display_name'];
        }
        $this->COIN_CHOICES = $coinChoices;
    }

    private function initChainNames()
    {
        $chainNames = array();
        foreach (static::COIN_SYMBOL_ODICT_LIST() as $x) {
            $chainNames[] = strtoupper($x['blockcypher_code']) . '.' . $x['blockcypher_network'];
        }
        $this->CHAIN_NAMES = $chainNames;
    }

    /**
     * @param $coinSymbol
     * @return string
     * @throws BlockCypherConfigurationException
     */
    public static function getDisplayShortname($coinSymbol)
    {
        if (!isset(self::getInstance()->COIN_SYMBOL_MAPPINGS[$coinSymbol]['display_shortname'])) {
            throw new BlockCypherConfigurationException(sprintf("Mapping not found for CoinSymbol %s and field display_shortname", $coinSymbol));
        }
        return self::getInstance()->COIN_SYMBOL_MAPPINGS[$coinSymbol]['display_shortname'];
    }

    /**
     * Returns the singleton object
     *
     * @return $this
     */
    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * @param string $coinSymbol
     * @return string
     * @throws BlockCypherConfigurationException
     */
    public static function getDisplayName($coinSymbol)
    {
        if (!isset(self::getInstance()->COIN_SYMBOL_MAPPINGS[$coinSymbol]['display_name'])) {
            throw new BlockCypherConfigurationException(sprintf("Mapping not found for CoinSymbol %s and field display_name", $coinSymbol));
        }
        return self::getInstance()->COIN_SYMBOL_MAPPINGS[$coinSymbol]['display_name'];
    }

    /**
     * @param $coinSymbol
     * @return string
     * @throws BlockCypherConfigurationException
     */
    public static function getCurrencyAbbrev($coinSymbol)
    {
        if (!isset(self::getInstance()->COIN_SYMBOL_MAPPINGS[$coinSymbol]['currency_abbrev'])) {
            throw new BlockCypherConfigurationException(sprintf("Mapping not found for CoinSymbol %s and field currency_abbrev", $coinSymbol));
        }
        return self::getInstance()->COIN_SYMBOL_MAPPINGS[$coinSymbol]['currency_abbrev'];
    }

    /**
     * @param $coinSymbol
     * @return string
     * @throws BlockCypherConfigurationException
     */
    public static function getBlockCypherCode($coinSymbol)
    {
        if (!isset(self::getInstance()->COIN_SYMBOL_MAPPINGS[$coinSymbol]['blockcypher_code'])) {
            throw new BlockCypherConfigurationException(sprintf("Mapping not found for CoinSymbol %s and field blockcypher_code", $coinSymbol));
        }
        return self::getInstance()->COIN_SYMBOL_MAPPINGS[$coinSymbol]['blockcypher_code'];
    }

    /**
     * @param $coinSymbol
     * @return string
     * @throws BlockCypherConfigurationException
     */
    public static function getBlockCypherNetwork($coinSymbol)
    {
        if (!isset(self::getInstance()->COIN_SYMBOL_MAPPINGS[$coinSymbol]['blockcypher_network'])) {
            throw new BlockCypherConfigurationException(sprintf("Mapping not found for CoinSymbol %s and field blockcypher_network", $coinSymbol));
        }
        return self::getInstance()->COIN_SYMBOL_MAPPINGS[$coinSymbol]['blockcypher_network'];
    }

    /**
     * Reverse mapping.
     * @param $code
     * @param $network
     * @return string|null
     */
    public static function getCoinSymbolFrom($code, $network)
    {
        foreach (self::COIN_SYMBOL_MAPPINGS() as $coinSymbol => $coinSymbolMapping) {
            if ($coinSymbolMapping['blockcypher_code'] == $code &&
                $coinSymbolMapping['blockcypher_network'] == $network
            ) {
                // Found
                return $coinSymbol;
            }
        }
        return null;
    }

    /**
     * @return array
     */
    public static function COIN_SYMBOL_MAPPINGS()
    {
        return self::getInstance()->COIN_SYMBOL_MAPPINGS;
    }

    /**
     * @return array
     */
    public static function COIN_SYMBOL_LIST()
    {
        return self::getInstance()->COIN_SYMBOL_LIST;
    }

    /**
     * @return array
     */
    public static function SHA_COINS()
    {
        return self::getInstance()->SHA_COINS;
    }

    /**
     * @return array
     */
    public static function SCRYPT_COINS()
    {
        return self::getInstance()->SCRYPT_COINS;
    }

    /**
     * @return array
     */
    public static function COIN_CHOICES()
    {
        return self::getInstance()->COIN_CHOICES;
    }

    /**
     * @return array
     */
    public static function CHAIN_NAMES()
    {
        return self::getInstance()->CHAIN_NAMES;
    }
}