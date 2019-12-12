<?php

namespace ClientSessionState\Impl;
use ClientSessionState\Contracts\SessionDataFormatter;

class RawStringFormatter implements SessionDataFormatter
{
    /**
     * outputs the encrypted string as it is
     *
     * @param string $input
     * @return mixed
     */
    public function format(string $input, ...$args)
    {
        return $input;
    }
}