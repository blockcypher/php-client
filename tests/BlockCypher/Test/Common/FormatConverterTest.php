<?php

namespace BlockCypher\Test\Common;

use BlockCypher\Converter\FormatConverter;

class FormatConverterTest extends \PHPUnit_Framework_TestCase
{
    public static function CurrencyListWithNoDecimalsProvider()
    {
        return array(
            array('JPY'),
            array('TWD')
        );
    }

    /**
     *
     * @dataProvider \BlockCypher\Test\Validation\NumericValidatorTest::positiveProvider
     */
    public function testFormatToTwoDecimalPlaces($input, $expected)
    {
        $result = FormatConverter::formatToNumber($input);
        $this->assertEquals($expected, $result);

    }

    /**
     * @dataProvider CurrencyListWithNoDecimalsProvider
     */
    public function testPriceWithNoDecimalCurrencyInvalid($input)
    {
        try {
            FormatConverter::formatToPrice("1.234", $input);
        } catch (\InvalidArgumentException $ex) {
            $this->assertContains("value cannot have decimals for", $ex->getMessage());
        }
    }

    /**
     * @dataProvider CurrencyListWithNoDecimalsProvider
     */
    public function testPriceWithNoDecimalCurrencyValid($input)
    {
        $result = FormatConverter::formatToPrice("1.0000000", $input);
        $this->assertEquals("1", $result);
    }

    /**
     *
     * @dataProvider \BlockCypher\Test\Validation\NumericValidatorTest::positiveProvider
     */
    public function testFormatToNumber($input, $expected)
    {
        $result = FormatConverter::formatToNumber($input);
        $this->assertEquals($expected, $result);
    }

    public function testFormatToNumberDecimals()
    {
        $result = FormatConverter::formatToNumber("0.0", 4);
        $this->assertEquals("0.0000", $result);
    }

    public function testFormat()
    {
        $result = FormatConverter::format("12.0123", "%0.2f");
        $this->assertEquals("12.01", $result);
    }
}
