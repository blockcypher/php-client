<?php
namespace BlockCypher\Test\Validation;

use BlockCypher\Validation\UrlValidator;

class UrlValidatorTest extends \PHPUnit_Framework_TestCase
{

    public static function positiveProvider()
    {
        return array(
            array("https://www.blockcypher.com"),
            array("http://www.blockcypher.com"),
            array("https://blockcypher.com"),
            array("https://www.blockcypher.com/directory/file"),
            array("https://www.blockcypher.com/directory/file?something=1&other=true"),
            array("https://www.blockcypher.com?value="),
            array("https://www.blockcypher.com/123123"),
            array("https://www.subdomain.blockcypher.com"),
            array("https://www.sub-domain-with-dash.blockcypher-website.com"),
            array("https://www.blockcypher.com?value=space%20separated%20value"),
            array("https://www.special@character.com"),
        );
    }

    public static function invalidProvider()
    {
        return array(
            array("www.blockcypher.com"),
            array(""),
            array(null),
            array("https://www.sub_domain_with_underscore.blockcypher.com"),
        );
    }

    /**
     *
     * @dataProvider positiveProvider
     */
    public function testValidate($input)
    {
        UrlValidator::validate($input, "Test Value");
    }

    /**
     *
     * @dataProvider invalidProvider
     * @expectedException \InvalidArgumentException
     */
    public function testValidateException($input)
    {
        UrlValidator::validate($input, "Test Value");
    }

}
