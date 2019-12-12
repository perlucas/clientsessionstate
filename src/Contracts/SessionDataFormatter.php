<?php

namespace ClientSessionState\Contracts;

/**
 * represents a formatter for the session data string (the encrypted session data)
 */
interface SessionDataFormatter
{
    /**
     * formats the encrypted session data
     *
     * @param string $input
     * @param mixed $arg1, $arg2...
     * @return mixed
     */
    public function format(string $input, ...$args);
}