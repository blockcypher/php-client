<?php

namespace BlockCypher\Test\Crypto;

use BlockCypher\Crypto\PrivateKeyManipulator;
use BlockCypher\Crypto\Signer;

/**
 * Class SignerTest
 * @package BlockCypher\Test\Crypto
 */
class SignerTest extends \PHPUnit_Framework_TestCase
{
    const PRIVATE_KEY = '1551558c3b75f46b71ec068f9e341bf35ee6df361f7b805deb487d8a4d5f055e';
    const TO_SIGN = 'd494ba34f5b2938aade8ac156d8099ba686f8b68de43e98d5fa35e367b6431f4';
    const SIGNATURE = '304402207b294405cf94117ec3ba2755d752712578180f486d3d4d12a112e7b2cfbfc88c02200e2dcc83ca8488eaf5a698fc04d5ef4daa99440cbc31b622ac7af7fe712c1e16';

    /**
     * @test
     */
    public function
    should_allow_sign_data_with_hex_private_key()
    {
        $signature = Signer::sign(self::TO_SIGN, self::PRIVATE_KEY);

        $this->assertEquals(self::SIGNATURE, $signature);
    }

    /**
     * @test
     */
    public function
    should_sign_data_deterministically()
    {
        $signature1 = Signer::sign(self::TO_SIGN, self::PRIVATE_KEY);
        $signature2 = Signer::sign(self::TO_SIGN, self::PRIVATE_KEY);

        $this->assertEquals(self::SIGNATURE, $signature1, $signature2);
    }

    /**
     * @test
     */
    public function
    should_allow_sign_data_with_private_key()
    {
        $privateKey = PrivateKeyManipulator::importPrivateKey(self::PRIVATE_KEY);

        $signature = Signer::sign(self::TO_SIGN, $privateKey);

        $this->assertEquals(self::SIGNATURE, $signature);
    }

    /**
     * @test
     */
    public function
    should_allow_sign_multiple_data_at_once()
    {
        $toSign = array(self::TO_SIGN);

        $signature = Signer::signMultiple($toSign, self::PRIVATE_KEY);

        $this->assertEquals(array(self::SIGNATURE), $signature);
    }

    /**
     * @dataProvider invalidSignMultipleParameters
     * @test
     * @expectedException \InvalidArgumentException
     * @param $toSign
     */
    public function
    should_only_allow_sign_multiple_data_from_an_array($toSign)
    {
        Signer::signMultiple($toSign, self::PRIVATE_KEY);
    }

    public function invalidSignMultipleParameters()
    {
        return array(
            array(null),
            array(''),
            array(1),
            array(1.0),
            array('text'),
        );
    }
}