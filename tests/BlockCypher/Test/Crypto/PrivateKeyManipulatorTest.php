<?php

namespace BlockCypher\Test\Crypto;

use BlockCypher\Crypto\CoinSymbolNetworkMapping;
use BlockCypher\Crypto\PrivateKeyManipulator;


/**
 * Class PrivateKeyManipulatorTest
 * @package BlockCypher\Test\Crypto
 */
class PrivateKeyManipulatorTest extends \PHPUnit_Framework_TestCase
{
    /** Sample BTC testnet address */
    const ADDRESS = 'n3D2YXwvpoPg8FhcWpzJiS3SvKKGD8AXZ4';
    const ADDRESS_PRIVATE_KEY = '1551558c3b75f46b71ec068f9e341bf35ee6df361f7b805deb487d8a4d5f055e';
    const ADDRESS_WIF = 'cNJ96rBRnL1dmcUdbRZjpRqTPRiChXWTJtR4u6WRUB4uGXQBynkH';
    const ADDRESS_PUBLIC_KEY = '0274cb62e999bdf96c9b4ef8a2b44c1ac54d9de879e2ee666fdbbf0e1a03090cdf';

    /**
     * @test
     */
    public function
    should_allow_import_private_key_fom_hex()
    {
        $privateKey = PrivateKeyManipulator::importPrivateKeyFromHex(self::ADDRESS_PRIVATE_KEY, true);

        $this->assertNotNull($privateKey);
        $this->assertInstanceOf('\BitWasp\Bitcoin\Key\PrivateKeyInterface', $privateKey);
        $this->assertEquals(self::ADDRESS_PRIVATE_KEY, $privateKey->getHex());
    }

    /**
     * @test
     */
    public function
    should_allow_import_private_key_fom_wif()
    {
        $privateKey = PrivateKeyManipulator::importPrivateKeyFromWif(self::ADDRESS_WIF);
        $network = CoinSymbolNetworkMapping::getNetwork('btc-testnet');

        $this->assertNotNull($privateKey);
        $this->assertInstanceOf('\BitWasp\Bitcoin\Key\PrivateKeyInterface', $privateKey);
        $this->assertEquals(self::ADDRESS_WIF, $privateKey->toWif($network));
    }

    /**
     * @test
     */
    public function
    should_allow_generate_hex_public_key_from_hex_private_key()
    {
        $hexPublicKey = PrivateKeyManipulator::generateHexPubKeyFromHexPrivKey(self::ADDRESS_PRIVATE_KEY);

        $this->assertEquals(self::ADDRESS_PUBLIC_KEY, $hexPublicKey);
    }

    /**
     * @test
     */
    public function
    should_allow_import_private_key_detecting_private_key_format()
    {
        $privKeyFromHex = PrivateKeyManipulator::importPrivateKey(self::ADDRESS_PRIVATE_KEY, true);
        $privKeyFromWif = PrivateKeyManipulator::importPrivateKey(self::ADDRESS_WIF);

        $this->assertEquals(self::ADDRESS_PRIVATE_KEY, $privKeyFromHex->getHex(), $privKeyFromWif->getHex());
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function
    should_throw_an_exception_importing_a_private_key_with_invalid_format()
    {
        PrivateKeyManipulator::importPrivateKey('INVALID PRIVATE KEY');
    }
}