<?php
namespace BlockCypher\Test\Converter;

use BlockCypher\Converter\BtcConverter;

class BtcConverterTest extends \PHPUnit_Framework_TestCase
{
    public static function positiveProviderBtcToSatoshis()
    {
        return array(
            array(1, 100000000),
            array(1.00, 100000000),
            array(2147483647 + 1, 2.147483648E+17), // max int 32 bits + 1
            array(9223372036854775807 + 1, 9.2233720368547758E+26), // max int 64 bits + 1
        );
    }

    public static function invalidProviderBtcToSatoshis()
    {
        return array(
            array(null, null),
            array('', null),
            array('     ', null),
            array('a', null),
            array('1a', null),
        );
    }

    public static function positiveProviderSatoshisToBtc()
    {
        return array(
            array(100000000, 1),
            array(100000000, 1.00),
            array(2147483647 + 1, 21.47483648), // max int 32 bits + 1
            array(9223372036854775807 + 1, 92233720368.54776), // max int 64 bits + 1
        );
    }

    public static function invalidProviderSatoshisToBtc()
    {
        return array(
            array(null, null),
            array('', null),
            array('     ', null),
            array('a', null),
            array('1a', null),
        );
    }

    public static function positiveProviderSatoshisToBtcRounded()
    {
        return array(
            array(100000000, 1),
            array(100000000, 1.00),
            array(2147483648, 21.4748),
            array(2147483647 + 1, 21.474799999999998), // max int 32 bits + 1
            array(9223372036854775807 + 1, 92233720368.547806), // max int 64 bits + 1
        );
    }

    public static function invalidProviderSatoshisToBtcRounded()
    {
        return array(
            array(null, null),
            array('', null),
            array('     ', null),
            array('a', null),
            array('1a', null),
        );
    }

    /**
     * @dataProvider positiveProviderBtcToSatoshis
     */
    public function testBtcToSatoshis($btc, $satoshis)
    {
        $this->assertEquals(BtcConverter::btcToSatoshis($btc), $satoshis);
    }

    /**
     * @dataProvider invalidProviderBtcToSatoshis
     * @expectedException \InvalidArgumentException
     */
    public function testInvalidDataBtcToSatoshis($btc, $satoshis)
    {
        $this->assertEquals(BtcConverter::btcToSatoshis($btc), $satoshis);
    }

    /**
     * @dataProvider positiveProviderSatoshisToBtc
     */
    public function testSatoshisToBtc($satoshis, $btc)
    {
        $this->assertEquals(BtcConverter::satoshisToBtc($satoshis), $btc);
    }

    /**
     * @dataProvider invalidProviderSatoshisToBtc
     * @expectedException \InvalidArgumentException
     */
    public function testInvalidDataSatoshisToBtc($satoshis, $btc)
    {
        $this->assertEquals(BtcConverter::satoshisToBtc($satoshis), $btc);
    }

    /**
     * @dataProvider positiveProviderSatoshisToBtcRounded
     */
    public function testSatoshisToBtcRounded($satoshis, $btc)
    {
        $this->assertEquals(BtcConverter::satoshisToBtcRounded($satoshis), $btc);
    }

    /**
     * @dataProvider invalidProviderSatoshisToBtcRounded
     * @expectedException \InvalidArgumentException
     */
    public function testInvalidDataSatoshisToBtcRounded($satoshis, $btc)
    {
        $this->assertEquals(BtcConverter::satoshisToBtcRounded($satoshis), $btc);
    }
}
