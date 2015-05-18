<?php

namespace BlockCypher\Test\Validation;

use BlockCypher\Validation\TokenValidator;

class TokenValidatorTest extends \PHPUnit_Framework_TestCase
{
    public static function positiveProvider()
    {
        return array(
            array("c0afcccdde5081d6429de37d16166ead"),
            array("de305d54-75b4-431b-adb2-eb6b9e546014"),
        );
    }

    public static function invalidProvider()
    {
        return array(
            array(null),
            array(""),
            array(" "),
            array("aa"),
            array("01234567890123456789abc-"),
            array("01234567890123456789abc&"),
            array("012345ah-01af-01af-01af-0123456789af"),
            array("012345af-01ag-01af-01af-0123456789af"),
            array("012345af-01af-01ag-01af-0123456789af"),
            array("012345af-01af-01af-01ag-0123456789af"),
            array("012345af-01af-01af-01af-0123456789ag"),
            array("0123456789-0123456789-&"),
            array("0123456789-0123456789-_"),
            array("0123456789-0123456789-M"),
        );
    }

    /**
     * @dataProvider positiveProvider
     */
    public function testValidateTrue($input)
    {
        $this->assertTrue(TokenValidator::validate($input));
    }

    /**
     * @dataProvider invalidProvider
     */
    public function testValidateFalse($input)
    {
        $this->assertFalse(TokenValidator::validate($input));
    }

}
