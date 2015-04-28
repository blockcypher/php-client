<?php

namespace BlockCypher\Test\Functional\Api;

use BlockCypher\Api\AddressBalance;
use BlockCypher\Test\Functional\Setup;

/**
 * Class AddressBalanceFunctionalTest
 *
 * @package BlockCypher\Test\Api
 */
class AddressBalanceFunctionalTest extends \PHPUnit_Framework_TestCase
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
     * @return AddressBalance
     */
    public function testGet()
    {
        $request = $this->operation['response']['body'];
        $address = new AddressBalance($request);

        $result = AddressBalance::get($address->getAddress(), array(), $this->apiContext, $this->mockBlockCypherRestCall);
        $this->assertNotNull($result);
        $this->assertInstanceOf('\BlockCypher\Api\AddressBalance', $result);
        // Assert only immutable values.
        $this->assertEquals($address->getAddress(), $result->getAddress());
        return $result;
    }

    /**
     * @return AddressBalance[]
     */
    public function testGetMultiple()
    {
        $request = $this->operation['response']['body'];
        $addressArray = AddressBalance::getList($request);

        $addressList = array();
        /** @var AddressBalance $address */
        foreach ($addressArray as $address) {
            $addressList[] = $address->getAddress();
        }

        $result = AddressBalance::getMultiple($addressList, array(), $this->apiContext, $this->mockBlockCypherRestCall);
        $this->assertNotNull($result);
        $this->assertContainsOnlyInstancesOf('\BlockCypher\Api\AddressBalance', $result);
        $this->assertEquals(count($result), count($addressList));
        foreach ($result as $addr) {
            $this->assertContains($addr->getAddress(), $addressList);
        }
        return $result;
    }
}
