<?php

namespace BlockCypher\Test\Crypto;

use BlockCypher\Crypto\Cipher;

/**
 * Class CipherTest
 * @package BlockCypher\Test\Crypto
 */
class CipherTest extends \PHPUnit_Framework_TestCase
{
    const SECRET_KEY = 'oh5eLcd6115UBJ=0"RH{00hUE/39Be';
    const SECRET_MESSAGE = 'Build block chain applications easily with our web APIs and callbacks';

    public function testEncryptionDecryption()
    {
        $cipher = new Cipher(self::SECRET_KEY);

        $secretMessageEncrypted = $cipher->encrypt(self::SECRET_MESSAGE);
        $secretMessage = $cipher->decrypt($secretMessageEncrypted);

        $this->assertNotEmpty($secretMessage, $secretMessageEncrypted);
        $this->assertNotEquals($secretMessage, $secretMessageEncrypted);
        $this->assertEquals(self::SECRET_MESSAGE, $secretMessage);
    }
}