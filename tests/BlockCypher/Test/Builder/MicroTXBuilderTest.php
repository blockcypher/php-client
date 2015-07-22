<?php

namespace BlockCypher\Test\Builder;

use BlockCypher\Builder\MicroTXBuilder;
use BlockCypher\Test\Api\MicroTXTest;

/**
 * Class MicroTXBuilderTest
 * @package BlockCypher\Test\Builder
 */
class MicroTXBuilderTest extends \PHPUnit_Framework_TestCase
{
    public function testBuild()
    {
        $expectedMicroTX = MicroTXTest::getObject();

        $microTX = MicroTXBuilder::newMicroTX()
            ->fromPubkey($expectedMicroTX->getFromPubkey())
            ->fromPrivate($expectedMicroTX->getFromPrivate())
            ->fromWif($expectedMicroTX->getFromWif())
            ->toAddress($expectedMicroTX->getToAddress())
            ->withValueInSatoshis($expectedMicroTX->getValueSatoshis())
            ->build();

        $this->assertEquals($expectedMicroTX->getFromPubkey(), $microTX->getFromPubkey());
        $this->assertEquals($expectedMicroTX->getFromPrivate(), $microTX->getFromPrivate());
        $this->assertEquals($expectedMicroTX->getFromWif(), $microTX->getFromWif());
        $this->assertEquals($expectedMicroTX->getToAddress(), $microTX->getToAddress());
        $this->assertEquals($expectedMicroTX->getValueSatoshis(), $microTX->getValueSatoshis());
    }
}