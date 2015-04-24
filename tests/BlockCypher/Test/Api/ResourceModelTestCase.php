<?php

namespace BlockCypher\Test\Api;

/**
 * Class ResourceModelTestCase
 *
 * @package BlockCypher\Test\Api
 */
class ResourceModelTestCase extends \PHPUnit_Framework_TestCase
{
    public function mockProvider()
    {
        $obj = static::getObject();

        $mockApiContext = $this->getMockApiContext();

        return array(
            array($obj, $mockApiContext),
            array($obj, null)
        );
    }

    /**
     * Gets Object Instance with Json data filled in
     * @return null
     */
    public static function getObject()
    {
        return null;
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    public function getMockApiContext()
    {
        $mockApiContext = $this->getMockBuilder('\BlockCypher\Rest\ApiContext')
            ->disableOriginalConstructor()
            ->setMethods(array('getBaseChainUrl'))
            ->getMock();

        $mockApiContext->expects($this->once())
            ->method('getBaseChainUrl')
            ->will($this->returnValue('/v1/btc/main'));

        return $mockApiContext;
    }

    public function mockProviderGetParamsValidation()
    {
        $obj = static::getObject();

        $mockApiContext = $this->getMockApiContext();

        return array(
            array($obj, $mockApiContext, null),
            array($obj, $mockApiContext, ''),
            array($obj, $mockApiContext, 'TestSample'),
        );
    }
}