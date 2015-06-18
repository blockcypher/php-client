<?php

namespace BlockCypher\Test\Functional\Api;

use BlockCypher\Api\Blockchain;
use BlockCypher\Test\Functional\Setup;

/**
 * Class BlockchainFunctionalTest
 *
 * @package BlockCypher\Test\Api
 */
class BlockchainFunctionalTest extends \PHPUnit_Framework_TestCase
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
     * @return Blockchain
     */
    public function testGet()
    {
        $request = $this->operation['response']['body'];
        $blockchain = new Blockchain($request);

        $result = Blockchain::get($blockchain->getName(), array(), $this->apiContext, $this->mockBlockCypherRestCall);
        $this->assertNotNull($result);
        $this->assertInstanceOf('\BlockCypher\Api\Blockchain', $result);
        // Assert only immutable values.
        $this->assertEquals($blockchain->getName(), $result->getName());
        return $result;
    }
}