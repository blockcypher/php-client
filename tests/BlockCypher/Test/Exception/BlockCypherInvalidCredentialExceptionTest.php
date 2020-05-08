<?php

use BlockCypher\Exception\BlockCypherInvalidCredentialException;

/**
 * Test class for BlockCypherInvalidCredentialException.
 *
 */
class BlockCypherInvalidCredentialExceptionTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var BlockCypherInvalidCredentialException
     */
    protected $object;

    /**
     * @test
     */
    public function testErrorMessage()
    {
        $msg = $this->object->errorMessage();
        $this->assertContains('Error on line', $msg);
    }

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp(): void
    {
        $this->object = new BlockCypherInvalidCredentialException;
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown(): void
    {
    }
}
