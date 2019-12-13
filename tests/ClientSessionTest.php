<?php

use ClientSessionState\ClientSession;
use PHPUnit\Framework\TestCase;

class ClientSessionTest extends TestCase
{

    protected $obj;

    protected $key = 'My KEY';

    protected function myString() {
        return 'abcf deaf 111';
    }

    protected function myArray() {
        return array(
            111, 222, 'abcdef', 'abcef gh 12', 'p' => 990, ['aa' => 222]
        );
    }

    protected function myObject() {
        $this->obj = (object) [
            'prop1' => [22, 44, 'ppo'],
            'prop2' => 'abce ff',
            'prop3' => 99
        ];
        return $this->obj;
    }

    public function testSet()
    {
        $session = ClientSession::instance();
        $session->set('my_string', $this->myString());
        $session->set('my_arr', $this->myArray());
        $session->set('my_obj', $this->myObject());
        $this->assertTrue($session->has('my_string'));
        $this->assertTrue($session->has('my_arr'));
        $this->assertTrue($session->has('my_obj'));
        $this->assertFalse($session->has('my_obj1'));
        return $session;
    }

    /**
     * 
     * @depends testSet
     */
    public function testGet($session)
    {
        $this->assertEquals($session->get('my_string'), $this->myString());
        $this->assertEquals($session->get('my_arr'), $this->myArray());
        $this->assertEquals($session->get('my_obj'), $this->myObject());
        return $session;
    }

    /**
     * @depends testGet
     */
    public function testRemove($session)
    {
        foreach (['my_string', 'my_arr', 'my_obj'] as $kk) {
            $session->remove($kk);
            $this->assertFalse($session->has($kk));
        }
        return $session;
    }

    public function testLoad()
    {
        $session = $this->testSet();
        $session->setEncodingKey($this->key);
        $encoded = $session->output()->string();
        $session->load($encoded);
        $this->testGet($session);
    }
}