<?php

namespace BlockCypher\Test\Validation;

use BlockCypher\Validation\ArgumentGetParamsValidator;
use PHPUnit_Framework_Error_Notice;

class ArgumentGetParamsValidatorTest extends \PHPUnit\Framework\TestCase
{

    public static function positiveProvider()
    {
        return array(
            array(array()),
            array(array('text')),
            array(array(1)),
            array(array(1.0)),
            array(array(true))
        );
    }

    public static function invalidProvider()
    {
        return array(
            array(null),
            array(''),
            array('     '),
            array(1),
            array(1.0),
            array(true),
            array(array(null)),
            array(array('')),
            array(array('     '))
        );
    }

    /**
     *
     * @dataProvider positiveProvider
     */
    public function testValidate($input)
    {
        $this->assertTrue(ArgumentGetParamsValidator::validate($input, "Name"));
    }

    /**
     *
     * @dataProvider invalidProvider
     */
    public function testInvalidDataValidate($input)
    {
        $this->expectException('\InvalidArgumentException');
        $this->assertTrue(ArgumentGetParamsValidator::validate($input, "Name"));
    }

    public function testsSanitize()
    {
        $params = array(
            'param1' => 'param1Value'
        );

        $allowedParams = array(
            'param1' => 'param1Value',
        );

        ArgumentGetParamsValidator::sanitize($params, $allowedParams);
    }

    public function testsSanitizeWithNotAllowedParams()
    {
        $this->expectException('\PHPUnit\Framework\Error\Notice');
        $params = array(
            'paramNotAllowed' => 'param1Value',
        );

        $allowedParams = array(
            'param1' => 'param1Value',
        );

        $validationLevel = 'strict';
        ArgumentGetParamsValidator::sanitize($params, $allowedParams, $validationLevel);
    }
}
