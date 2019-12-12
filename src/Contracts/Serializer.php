<?php

namespace ClientSessionState\Contracts;

/**
 * represents a serializer object
 */
interface Serializer
{
    /**
     * serializes a piece of data returning the string representation
     *
     * @param mixed $data
     * @return string
     */
    public function serialize(mixed $data): string;

    /**
     * restores te piece of data from its string representation
     *
     * @param string $serializedData
     * @return mixed
     */
    public function deserialize(string $serializedData): mixed;
}