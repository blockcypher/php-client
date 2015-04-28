<?php

namespace BlockCypher\Test\Functional\Api;

use BlockCypher\Api\FullAddress;
use BlockCypher\Test\Functional\Setup;

/**
 * Class FullAddressFunctionalTest
 *
 * @package BlockCypher\Test\Api
 */
class FullAddressFunctionalTest extends \PHPUnit_Framework_TestCase
{
    public $operation;

    public $response;

    public $mockBlockCypherRestCall;

    public $apiContext;

    public function setUp()
    {
        $className = $this->getClassName();
        $testName = $this->getName();
        $operationString = file_get_contents(__DIR__ . "/../resources/$className/$testName.json");
        $this->operation = Setup::jsonDecode($operationString);
        $this->response = true;
        if (array_key_exists('body', $this->operation['response'])) {
            $this->response = json_encode($this->operation['response']['body']);
        }
        Setup::SetUpForFunctionalTests($this);
    }

    /**
     * Returns just the classname of the test you are executing. It removes the namespaces.
     * @return string
     */
    public function getClassName()
    {
        return join('', array_slice(explode('\\', get_class($this)), -1));
    }

    /**
     * @return FullAddress
     */
    public function testGet()
    {
        $request = $this->operation['response']['body'];
        $fullAddress = new FullAddress($request);

        $result = FullAddress::get($fullAddress->getAddress(), array(), $this->apiContext, $this->mockBlockCypherRestCall);
        $this->assertNotNull($result);
        $this->assertInstanceOf('\BlockCypher\Api\FullAddress', $result);
        // Assert only immutable values.
        $this->assertEquals($fullAddress->getAddress(), $result->getAddress());
        return $result;
    }

    /**
     * @return FullAddress[]
     */
    public function testGetMultiple()
    {
        $request = $this->operation['response']['body'];
        $fullAddressArray = FullAddress::getList($request);

        $fullAddressList = array();
        /** @var FullAddress $fullAddress */
        foreach ($fullAddressArray as $fullAddress) {
            $fullAddressList[] = $fullAddress->getAddress();
        }

        $result = FullAddress::getMultiple($fullAddressList, array(), $this->apiContext, $this->mockBlockCypherRestCall);
        $this->assertNotNull($result);
        $this->assertContainsOnlyInstancesOf('\BlockCypher\Api\FullAddress', $result);
        $this->assertEquals(count($result), count($fullAddressList));
        foreach ($result as $fullAddr) {
            $this->assertContains($fullAddr->getAddress(), $fullAddressList);
        }
        return $result;
    }
}
