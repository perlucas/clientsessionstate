<?php

namespace ClientSessionState\Impl;
use ClientSessionState\Contracts\Serializer;

class BasicPHPSerializer implements Serializer
{
    /**
     * serializes an array of data returning the string representation
     *
     * @param array $data
     * @return string
     */
    public function serialize(array $data): string
    {
        return \serialize($data);
    }

    /**
     * restores the array of data from its string representation
     *
     * @param string $serializedData
     * @return array
     */
    public function deserialize(string $serializedData): array
    {
        return \unserialize($serializedData);
    }
}