<?php

use BlockCypher\Core\BlockCypherCoinSymbolConstants;

/**
 * Test class for BlockCypherCoinSymbolConstants.
 */
class BlockCypherCoinSymbolConstantsTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function testGetInstance()
    {
        $instance = BlockCypherCoinSymbolConstants::getInstance();
        $this->assertTrue($instance instanceof BlockCypherCoinSymbolConstants);
    }

    public function positiveGetDisplayNameProvider()
    {
        return array(
            array("btc", "Bitcoin"),
            array("btc-testnet", "Bitcoin Testnet"),
            array("ltc", "Litecoin"),
            array("doge", "Dogecoin"),
            array("uro", "Uro"),
            array("bcy", "BlockCypher Testnet"),
        );
    }

    public function invalidGetDisplayNameProvider()
    {
        return array(
            array(null),
            array(""),
            array(" "),
        );
    }

    /**
     * @test
     * @dataProvider positiveGetDisplayNameProvider
     * @param $coinSymbol
     * @param $displayName
     */
    public function testGetDisplayName($coinSymbol, $displayName)
    {
        $this->assertEquals(BlockCypherCoinSymbolConstants::getDisplayName($coinSymbol), $displayName);
    }

    /**
     * @test
     * @dataProvider invalidGetDisplayNameProvider
     * @expectedException \BlockCypher\Exception\BlockCypherConfigurationException
     * @param mixed $coinSymbol
     * @throws \BlockCypher\Exception\BlockCypherConfigurationException
     */
    public function testGetDisplayNameInvalidInput($coinSymbol)
    {
        BlockCypherCoinSymbolConstants::getDisplayName($coinSymbol);
    }

    public function positiveGetCurrencyAbbrevProvider()
    {
        return array(
            array("btc", "BTC"),
            array("btc-testnet", "BTC"),
            array("ltc", "LTC"),
            array("doge", "DOGE"),
            array("uro", "URO"),
            array("bcy", "BCY"),
        );
    }

    public function invalidGetCurrencyAbbrevProvider()
    {
        return array(
            array(null),
            array(""),
            array(" "),
        );
    }

    /**
     * @test
     * @dataProvider positiveGetCurrencyAbbrevProvider
     * @param $coinSymbol
     * @param $displayName
     */
    public function testGetCurrencyAbbrev($coinSymbol, $displayName)
    {
        $this->assertEquals(BlockCypherCoinSymbolConstants::getCurrencyAbbrev($coinSymbol), $displayName);
    }

    /**
     * @test
     * @dataProvider invalidGetCurrencyAbbrevProvider
     * @expectedException \BlockCypher\Exception\BlockCypherConfigurationException
     * @param mixed $coinSymbol
     * @throws \BlockCypher\Exception\BlockCypherConfigurationException
     */
    public function testGetCurrencyAbbrevInvalidInput($coinSymbol)
    {
        BlockCypherCoinSymbolConstants::getCurrencyAbbrev($coinSymbol);
    }

    public function positiveGetBlockCypherCodeProvider()
    {
        return array(
            array("btc", "btc"),
            array("btc-testnet", "btc"),
            array("ltc", "ltc"),
            array("doge", "doge"),
            array("uro", "uro"),
            array("bcy", "bcy"),
        );
    }

    public function invalidGetBlockCypherCodeProvider()
    {
        return array(
            array(null),
            array(""),
            array(" "),
        );
    }

    /**
     * @test
     * @dataProvider positiveGetBlockCypherCodeProvider
     * @param $coinSymbol
     * @param $displayName
     */
    public function testGetBlockCypherCode($coinSymbol, $displayName)
    {
        $this->assertEquals(BlockCypherCoinSymbolConstants::getBlockCypherCode($coinSymbol), $displayName);
    }

    /**
     * @test
     * @dataProvider invalidGetBlockCypherCodeProvider
     * @expectedException \BlockCypher\Exception\BlockCypherConfigurationException
     * @param mixed $coinSymbol
     * @throws \BlockCypher\Exception\BlockCypherConfigurationException
     */
    public function testGetBlockCypherCodeInvalidInput($coinSymbol)
    {
        BlockCypherCoinSymbolConstants::getBlockCypherCode($coinSymbol);
    }

    public function positiveGetBlockCypherNetworkProvider()
    {
        return array(
            array("btc", "main"),
            array("btc-testnet", "test3"),
            array("ltc", "main"),
            array("doge", "main"),
            array("uro", "main"),
            array("bcy", "test"),
        );
    }

    public function invalidGetBlockCypherNetworkProvider()
    {
        return array(
            array(null),
            array(""),
            array(" "),
        );
    }

    /**
     * @test
     * @dataProvider positiveGetBlockCypherNetworkProvider
     * @param $coinSymbol
     * @param $displayName
     */
    public function testGetBlockCypherNetwork($coinSymbol, $displayName)
    {
        $this->assertEquals(BlockCypherCoinSymbolConstants::getBlockCypherNetwork($coinSymbol), $displayName);
    }

    /**
     * @test
     * @dataProvider invalidGetBlockCypherNetworkProvider
     * @expectedException \BlockCypher\Exception\BlockCypherConfigurationException
     * @param mixed $coinSymbol
     * @throws \BlockCypher\Exception\BlockCypherConfigurationException
     */
    public function testGetBlockCypherNetworkInvalidInput($coinSymbol)
    {
        BlockCypherCoinSymbolConstants::getBlockCypherNetwork($coinSymbol);
    }

    /**
     * @test
     */
    public function testCOIN_SYMBOL_MAPPINGS()
    {
        $expectedCoinSymbolMappings = array(
            'btc' => array(
                'display_name' => 'Bitcoin',
                'display_shortname' => 'BTC',
                'blockcypher_code' => 'btc',
                'blockcypher_network' => 'main',
                'currency_abbrev' => 'BTC',
                'pow' => 'sha',
                'example_address' => '16Fg2yjwrbtC6fZp61EV9mNVKmwCzGasw5',
                "address_first_char_list" => array('1', '3')
            ),
            'btc-testnet' => array(
                'display_name' => 'Bitcoin Testnet',
                'display_shortname' => 'BTC Testnet',
                'blockcypher_code' => 'btc',
                'blockcypher_network' => 'test3',
                'currency_abbrev' => 'BTC',
                'pow' => 'sha',
                'example_address' => '2N1rjhumXA3ephUQTDMfGhufxGQPZuZUTMk',
                "address_first_char_list" => array('m', 'n', '2')
            ),
            'ltc' => array(
                'display_name' => 'Litecoin',
                'display_shortname' => 'LTC',
                'blockcypher_code' => 'ltc',
                'blockcypher_network' => 'main',
                'currency_abbrev' => 'LTC',
                'pow' => 'scrypt',
                'example_address' => 'LcFFkbRUrr8j7TMi8oXUnfR4GPsgcXDepo',
                "address_first_char_list" => array('L', 'U', '3')  // TODO: confirm
            ),
            'doge' => array(
                'display_name' => 'Dogecoin',
                'display_shortname' => 'DOGE',
                'blockcypher_code' => 'doge',
                'blockcypher_network' => 'main',
                'currency_abbrev' => 'DOGE',
                'pow' => 'scrypt',
                'example_address' => 'D7Y55r6Yoc1G8EECxkQ6SuSjTgGJJ7M6yD',
                "address_first_char_list" => array('D', '9', 'A')
            ),
            'uro' => array(
                'display_name' => 'Uro',
                'display_shortname' => 'URO',
                'blockcypher_code' => 'uro',
                'blockcypher_network' => 'main',
                'currency_abbrev' => 'URO',
                'pow' => 'sha',
                'example_address' => 'Uhf1LGdgmWe33hB9VVtubyzq1GduUAtaAJ',
                "address_first_char_list" => array('U')  // TODO: more?
            ),
            'bcy' => array(
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

        $this->assertEquals($expectedCoinSymbolMappings, BlockCypherCoinSymbolConstants::COIN_SYMBOL_MAPPINGS());
    }

    /**
     * @test
     */
    public function testCOIN_SYMBOL_LIST()
    {
        $expectedCoinSymbolList = array('btc', 'btc-testnet', 'ltc', 'doge', 'uro', 'bcy');
        $this->assertEquals($expectedCoinSymbolList, BlockCypherCoinSymbolConstants::COIN_SYMBOL_LIST());
    }

    /**
     * @test
     */
    public function testSHA_COINS()
    {
        $expectedShaCoins = array('btc', 'btc-testnet', 'uro', 'bcy');
        $this->assertEquals($expectedShaCoins, BlockCypherCoinSymbolConstants::SHA_COINS());
    }

    /**
     * @test
     */
    public function testSCRYPT_COINS()
    {
        $expectedScryptCoins = array('ltc', 'doge');
        $this->assertEquals($expectedScryptCoins, BlockCypherCoinSymbolConstants::SCRYPT_COINS());
    }

    /**
     * @test
     */
    public function testCOIN_CHOICES()
    {
        $expectedCoinChoices = array(
            'btc' => 'Bitcoin',
            'btc-testnet' => 'Bitcoin Testnet',
            'ltc' => 'Litecoin',
            'doge' => 'Dogecoin',
            'uro' => 'Uro',
            'bcy' => 'BlockCypher Testnet'
        );
        $this->assertEquals($expectedCoinChoices, BlockCypherCoinSymbolConstants::COIN_CHOICES());
    }

    /**
     * @test
     */
    public function testCHAIN_NAMES()
    {
        $expectedChainNames = array(
            'BTC.main',
            'BTC.test3',
            'LTC.main',
            'DOGE.main',
            'URO.main',
            'BCY.test',
        );
        $this->assertEquals($expectedChainNames, BlockCypherCoinSymbolConstants::CHAIN_NAMES());
    }

    /**
     * @test
     * @expectedException \BlockCypher\Exception\BlockCypherConfigurationException
     */
    public function testAllRequiredFieldsArePresent()
    {
        new BlockCypherCoinSymbolConstantsRequiredFieldConfigError();
    }

    /**
     * @test
     * @expectedException \BlockCypher\Exception\BlockCypherConfigurationException
     */
    public function testInvalidPow()
    {
        new BlockCypherCoinSymbolConstantsInvalidPowConfigError();
    }

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
    }
}

class BlockCypherCoinSymbolConstantsRequiredFieldConfigError extends BlockCypherCoinSymbolConstants
{
    /**
     * List of Coin Symbol Ordered Dictionaries
     * @const array
     */
    protected static /** @noinspection SpellCheckingInspection */
        $COIN_SYMBOL_ODICT_LIST = array(
        array(
            'coin_symbol_NOT_PRESENT' => 'btc',  // <-- NOTICE!!!
            'display_name' => 'Bitcoin',
            'display_shortname' => 'BTC',
            'blockcypher_code' => 'btc',
            'blockcypher_network' => 'main',
            'currency_abbrev' => 'BTC',
            'pow' => 'sha',
            'example_address' => '16Fg2yjwrbtC6fZp61EV9mNVKmwCzGasw5',
            "address_first_char_list" => array('1', '3')
        )
    );
}

class BlockCypherCoinSymbolConstantsInvalidPowConfigError extends BlockCypherCoinSymbolConstants
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
            'pow' => 'INVALID_POW',  // <-- NOTICE!!!
            'example_address' => '16Fg2yjwrbtC6fZp61EV9mNVKmwCzGasw5',
            "address_first_char_list" => array('1', '3')
        )
    );
}
