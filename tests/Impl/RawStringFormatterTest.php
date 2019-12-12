<?php

use PHPUnit\Framework\TestCase;
use ClientSessionState\Impl\RawStringFormatter;

class RawStringFormatterTest extends TestCase
{
    public function testFormat()
    {
        $i = new RawStringFormatter;
        $ss = "daldjank|1ad718e123m,as,mxasad901+";
        $this->assertEquals($ss, $i->format($ss));
    }

}