<?php

use PHPUnit\Framework\TestCase;
use ClientSessionState\Impl\FormInputNodeFormatter;

class FormInputNodeFormatterTest extends TestCase
{
    public function testDefaultInput()
    {
        $ff = new FormInputNodeFormatter;
        $input = "<input name = 'session_data' id = 'session_data' type = 'hidden' value = 'abcd' />";
        $this->assertEquals($ff->format("abcd"), $input);
    }
    
    public function testCustomInput()
    {
        $ff = new FormInputNodeFormatter;
        $input = "<input name = 'sss' id = 'session_data' type = 'text' value = 'abcd' />";
        $this->assertEquals($ff->format("abcd", [
            'name' => 'sss',
            'type' => 'text'
        ]), $input);
    }

    public function testEscapeQuotes()
    {
        $ff = new FormInputNodeFormatter;
        $input = "<input name = 'sss' id = 'session_data' type = 'text' value = 'abcd\\'a' />";
        $this->assertEquals($ff->format("abcd'a", [
            'name' => 'sss',
            'type' => 'text'
        ]), $input);
    }
}