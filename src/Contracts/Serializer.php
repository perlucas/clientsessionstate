<?php

namespace ClientSessionState\Contracts;

/**
 * represents a serializer object
 */
interface Serializer
{
    /**
     * serializes an array of data returning the string representation
     *
     * @param array $data
     * @return string
     */
    public function serialize(array $data): string;

    /**
     * restores the array of data from its string representation
     *
     * @param string $serializedData
     * @return array
     */
    public function deserialize(string $serializedData): array;
}