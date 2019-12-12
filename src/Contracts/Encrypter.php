<?php

namespace ClientSessionState\Contracts;

/**
 * represents an encrypter object
 */
interface Encrypter
{
    /**
     * encrypts a string using the key
     *
     * @param string $key
     * @param string $data
     * @return string
     */
    public function encrypt(string $key, string $data): string;

    /**
     * restores the string using the key
     *
     * @param string $key
     * @param string $encryptedData
     * @return string
     */
    public function decrypt(string $key, string $encryptedData): string;
}