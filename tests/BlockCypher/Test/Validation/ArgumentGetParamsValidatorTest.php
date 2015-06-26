<?php
namespace BlockCypher\Test\Validation;

use BlockCypher\Validation\ArgumentGetParamsValidator;
use PHPUnit_Framework_Error_Notice;

class ArgumentGetParamsValidatorTest extends \PHPUnit_Framework_TestCase
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
     * @expectedException \InvalidArgumentException
     */
    public function testInvalidDataValidate($input)
    {
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

    /**
     * @expectedException PHPUnit_Framework_Error_Notice
     */
    public function testsSanitizeWithNotAllowedParams()
    {
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
