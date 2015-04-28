<?php

namespace BlockCypher\Test\Functional\Api;

use BlockCypher\Api\Block;
use BlockCypher\Test\Functional\Setup;

/**
 * Class BlockFunctionalTest
 *
 * @package BlockCypher\Test\Api
 */
class BlockFunctionalTest extends \PHPUnit_Framework_TestCase
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
     * @return Block
     */
    public function testGet()
    {
        $request = $this->operation['response']['body'];
        $block = new Block($request);

        $result = Block::get($block->getHash(), array(), $this->apiContext, $this->mockBlockCypherRestCall);
        $this->assertNotNull($result);
        $this->assertInstanceOf('\BlockCypher\Api\Block', $result);
        // Assert only immutable values.
        $this->assertEquals($block->getHash(), $result->getHash());
        $this->assertEquals($block->getTxUrl(), $result->getTxUrl());
        $this->assertEquals($block->getTxids(), $result->getTxids());
        return $result;
    }

    /**
     * @return Block
     */
    public function testGetByHeight()
    {
        $request = $this->operation['response']['body'];
        $block = new Block($request);

        $result = Block::get($block->getHeight(), array(), $this->apiContext, $this->mockBlockCypherRestCall);
        $this->assertNotNull($result);
        $this->assertInstanceOf('\BlockCypher\Api\Block', $result);
        // Assert only immutable values.
        $this->assertEquals($block->getHash(), $result->getHash());
        $this->assertEquals($block->getTxUrl(), $result->getTxUrl());
        $this->assertEquals($block->getTxids(), $result->getTxids());
        return $result;
    }

    /**
     * @return Block[]
     */
    public function testGetMultiple()
    {
        $request = $this->operation['response']['body'];
        $blockArray = Block::getList($request);

        $blockList = array();
        /** @var Block $block */
        foreach ($blockArray as $block) {
            $blockList[] = $block->getHash();
        }

        $result = Block::getMultiple($blockList, array(), $this->apiContext, $this->mockBlockCypherRestCall);
        $this->assertNotNull($result);
        $this->assertContainsOnlyInstancesOf('\BlockCypher\Api\Block', $result);
        $this->assertEquals(count($result), count($blockList));
        foreach ($result as $resultBlock) {
            $this->assertContains($resultBlock->getHash(), $blockList);
        }
        return $result;
    }

    /**
     * @return Block
     */
    public function testGetWithPaging()
    {
        $request = $this->operation['response']['body'];
        $block = new Block($request);

        $params = array(
            'txstart' => 1,
            'limit' => 1,
        );

        $result = Block::get($block->getHash(), $params, $this->apiContext, $this->mockBlockCypherRestCall);
        $this->assertNotNull($result);
        $this->assertInstanceOf('\BlockCypher\Api\Block', $result);
        // Assert only immutable values.
        $this->assertEquals($block->getHash(), $result->getHash());
        $this->assertEquals($block->getTxUrl(), $result->getTxUrl());
        $this->assertEquals(count($block->getTxids()), count($result->getTxids()));

        return $result;
    }
}