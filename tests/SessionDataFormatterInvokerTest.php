<?php

use ClientSessionState\SessionDataFormatterInvoker;
use ClientSessionState\Impl\RawStringFormatter;
use PHPUnit\Framework\TestCase;
use ClientSessionState\Contracts\SessionDataFormatter;


class SessionDataFormatterInvokerTest extends TestCase
{
    protected static $ENC = "abcd";

    public function testFormatter()
    {
        $invoker = new SessionDataFormatterInvoker;
        $invoker->setEncodedSession(static::$ENC);
        $invoker->setFormatter('input', new RawStringFormatter);
        $this->assertEquals(static::$ENC, $invoker->input());
        return $invoker;
    }

    /**
     * @depends testFormatter
     */
    public function testWithArguments($invoker)
    {
        declareFF();
        $invoker->setFormatter('ff', new FF);
        $this->assertEquals(3, $invoker->ff(1, 2));
    }
}

function declareFF()
{
    class FF implements SessionDataFormatter
    {
        public function format(string $in, ...$args)
        {
            return $args[0] + $args[1];
        }
    }
}