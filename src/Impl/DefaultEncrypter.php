<?php

namespace ClientSessionState\Impl;
use ClientSessionState\Contracts\Encrypter;

class DefaultEncrypter implements Encrypter
{
    /**
     * encryption method
     *
     * @var string
     */
    protected $method;

    /**
     * options for encryption function
     *
     * @var mixed
     */
    protected $options;

    /**
     * encryption initialization vector
     *
     * @var string
     */
    protected $encryption_iv;

    /**
     * constructs an instance
     */
    public function __construct()
    {
        $this->method = "AES-128-CTR";
        $this->encryption_iv = '1234567891011121'; 
        $this->options = 0;
    }

    /**
     * encrypts a string using the key
     *
     * @param string $key
     * @param string $data
     * @return string
     */
    public function encrypt(string $key, string $data): string
    {
        return \openssl_encrypt(
            $data, 
            $this->method,
            $key, 
            $this->options, 
            $this->encryption_iv
        );
    }

    /**
     * restores the string using the key
     *
     * @param string $key
     * @param string $encryptedData
     * @return string
     */
    public function decrypt(string $key, string $encryptedData): string
    {
        return \openssl_decrypt(
            $encryptedData, 
            $this->method,  
            $key, 
            $this->options, 
            $this->encryption_iv
        ); 
    }

}