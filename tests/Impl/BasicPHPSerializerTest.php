<?php

use PHPUnit\Framework\TestCase;
use ClientSessionState\Impl\BasicPHPSerializer;

class BasicPHPSerializerTest extends TestCase
{
    /**
     * @dataProvider provider
     */
    public function testSerialize($param)
    {
        $s = new BasicPHPSerializer;
        $this->assertEquals($s->serialize($param), serialize($param));
    }

    /**
     * 
     * @dataProvider provider
     */
    public function testDeserialize($arr)
    {
        $s = new BasicPHPSerializer;
        $serialized = $s->serialize($arr);
        $this->assertEquals($s->deserialize($serialized), $arr);
    }

    public function provider()
    {
        return [
            [
                array()
            ],
            [
                [1, 34, 55, 'papa', 'abc44']
            ],
            [
                [
                    'ppp' => 89,
                    88 => 'pipi',
                    'anccbcb' => 44.5,
                    99 => true
                ]
            ]
        ];
    }
}