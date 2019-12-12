<?php

use PHPUnit\Framework\TestCase;
use ClientSessionState\Impl\DefaultEncrypter;

class DefaultEncrypterTest extends TestCase
{
    protected $string = "ABCDEF3345566:ppp=1111,ooo,000;0plllh334.221";

    protected $crypt;

    protected $key = "my_key";

    protected function setUp(): void
    {
        $this->crypt = new DefaultEncrypter;
    }

    public function testEncryption()
    {
        $encrypted = $this->crypt->encrypt($this->key, $this->string);
        $this->assertNotEquals($this->string, $encrypted);
        return $encrypted;
    }

    /**
     *
     * @depends testEncryption
     */
    public function testDecryption($encrypted)
    {
        $this->assertEquals(
            $this->string,
            $this->crypt->decrypt(
                $this->key,
                $encrypted
            )
        );
    }
}