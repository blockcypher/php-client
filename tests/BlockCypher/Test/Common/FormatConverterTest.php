<?php

namespace BlockCypher\Test\Common;

use BlockCypher\Api\Currency;
use BlockCypher\Common\BlockCypherModel;
use BlockCypher\Converter\FormatConverter;
use BlockCypher\Test\Validation\NumericValidatorTest;

class FormatConverterTest extends \PHPUnit_Framework_TestCase
{

    public static function CurrencyListWithNoDecimalsProvider()
    {
        return array(
            // TODO: add method to get all virtual currencies codes supported by the API.
            array('BTC'),
            array('JPY'),
            array('TWD')
        );
    }

    public static function apiModelSettersProvider()
    {
        $provider = array();
        foreach (NumericValidatorTest::positiveProvider() as $value) {
            foreach (self::classMethodListProvider() as $method) {
                $provider[] = array_merge($method, array($value));
            }
        }
        return $provider;
    }

    public static function classMethodListProvider()
    {
        return array(
            array(new Currency(), 'Value')
        );
    }

    public static function apiModelSettersInvalidProvider()
    {
        $provider = array();
        foreach (NumericValidatorTest::invalidProvider() as $value) {
            foreach (self::classMethodListProvider() as $method) {
                $provider[] = array_merge($method, array($value));
            }
        }
        return $provider;
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

    /**
     * @dataProvider apiModelSettersProvider
     *
     * @param BlockCypherModel $class Class Object
     * @param string $method Method Name where the format is being applied
     * @param array $values array of ['input', 'expectedResponse'] is provided
     */
    public function testSettersOfKnownApiModel($class, $method, $values)
    {
        $obj = new $class();
        $setter = "set" . $method;
        $getter = "get" . $method;
        $result = $obj->$setter($values[0]);
        $this->assertEquals($values[1], $result->$getter());
    }

    /**
     * @dataProvider apiModelSettersInvalidProvider
     * @expectedException \InvalidArgumentException
     */
    public function testSettersOfKnownApiModelInvalid($class, $methodName, $values)
    {
        $obj = new $class();
        $setter = "set" . $methodName;
        $obj->$setter($values[0]);
    }
}
