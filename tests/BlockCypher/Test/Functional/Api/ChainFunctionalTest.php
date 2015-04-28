<?php

namespace BlockCypher\Test\Functional\Api;

use BlockCypher\Api\Chain;
use BlockCypher\Test\Functional\Setup;

/**
 * Class ChainFunctionalTest
 *
 * @package BlockCypher\Test\Api
 */
class ChainFunctionalTest extends \PHPUnit_Framework_TestCase
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
     * @return Chain
     */
    public function testGet()
    {
        $request = $this->operation['response']['body'];
        $chain = new Chain($request);

        $result = Chain::get($chain->getName(), array(), $this->apiContext, $this->mockBlockCypherRestCall);
        $this->assertNotNull($result);
        $this->assertInstanceOf('\BlockCypher\Api\Chain', $result);
        // Assert only immutable values.
        $this->assertEquals($chain->getName(), $result->getName());
        return $result;
    }
}