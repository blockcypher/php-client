<?php

use BlockCypher\Core\BlockCypherLoggingManager;

/**
 * Test class for BlockCypherLoggingManager.
 *
 */
class BlockCypherLoggingManagerTest extends \PHPUnit\Framework\TestCase
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
        $this->assertNull($this->object->error('Test Error Message'));
    }

    /**
     * @test
     */
    public function testWarning()
    {
        $this->assertNull($this->object->warning('Test Warning Message'));
    }

    /**
     * @test
     */
    public function testInfo()
    {
        $this->assertNull($this->object->info('Test info Message'));
    }

    /**
     * @test
     */
    public function testDebug()
    {
        $this->assertNull($this->object->debug('Test debug Message'));
    }

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp(): void
    {
        $this->object = BlockCypherLoggingManager::getInstance('AddressTest');
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown(): void
    {
    }
}
