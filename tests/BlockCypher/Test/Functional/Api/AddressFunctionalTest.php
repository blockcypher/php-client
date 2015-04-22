<?php

namespace BlockCypher\Test\Functional\Api;

use BlockCypher\Api\Address;
use BlockCypher\Test\Functional\Setup;

/**
 * Class AddressFunctionalTest
 *
 * @package BlockCypher\Test\Api
 */
class AddressFunctionalTest extends \PHPUnit_Framework_TestCase
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
        $this->operation = json_decode($operationString, true);
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
     * @return Address
     */
    public function testGet()
    {
        $request = $this->operation['response']['body'];
        $address = new Address($request);

        $result = Address::get($address->getAddress(), array(), $this->apiContext, $this->mockBlockCypherRestCall);
        $this->assertNotNull($result);
        $this->assertEquals($address->getAddress(), $result->getAddress());
        // TODO: all fields should be equal except some values as confirmations
        // Assert only immutable values.
        //$this->assertEquals($address, $result, "", 0, 10, true);
        return $result;
    }
}
