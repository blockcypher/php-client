<?php
namespace BlockCypher\Test\Validation;

use BlockCypher\Core\BlockCypherCoinSymbolConstants;
use BlockCypher\Validation\CoinSymbolValidator;

class CoinSymbolValidatorTest extends \PHPUnit_Framework_TestCase
{

    public static function positiveProvider()
    {
        BlockCypherCoinSymbolConstants::COIN_SYMBOL_LIST();

        $positiveValues = array();
        foreach (BlockCypherCoinSymbolConstants::COIN_SYMBOL_LIST() as $coinSymbol) {
            $positiveValues[] = array($coinSymbol);
        }

        return $positiveValues;
    }

    public static function invalidProvider()
    {
        return array(
            array(null),
            array(''),
            array('     '),
            array('INVALID COIN SYMBOL'),
            array(1),
            array(1.0),
            array(true)
        );
    }

    /**
     *
     * @dataProvider positiveProvider
     */
    public function testValidate($input)
    {
        $this->assertTrue(CoinSymbolValidator::validate($input, "Name"));
    }

    /**
     *
     * @dataProvider invalidProvider
     * @expectedException \InvalidArgumentException
     */
    public function testInvalidDataValidate($input)
    {
        $this->assertTrue(CoinSymbolValidator::validate($input, "Name"));
    }

}
