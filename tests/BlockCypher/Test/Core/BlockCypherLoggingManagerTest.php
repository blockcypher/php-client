<?php

use BlockCypher\Core\BlockCypherLoggingManager;

/**
 * Test class for BlockCypherLoggingManager.
 *
 */
class BlockCypherLoggingManagerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var BlockCypherLoggingManager
     */
    protected $object;

    /**
     * @test
     */
    public function testError()
    {
        $this->object->error('Test Error Message');

    }

    /**
     * @test
     */
    public function testWarning()
    {
        $this->object->warning('Test Warning Message');
    }

    /**
     * @test
     */
    public function testInfo()
    {
        $this->object->info('Test info Message');
    }

    /**
     * @test
     */
    public function testDebug()
    {
        $this->object->debug('Test debug Message');
    }

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = BlockCypherLoggingManager::getInstance('AddressTest');
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
    }
}