<?php

namespace ClientSessionState;

abstract class ClientSession
{
    public abstract function set(string $sessionKey, mixed $data);
    
    public abstract function get(string $sessionKey): mixed;
    
    public abstract function has(string $sessionKey): boolean;
    
    public abstract function remove(string $sessionKey);

    public abstract function setEncodingKey(string $key);

    public abstract function output(): SessionDataFormatterInvoker;

    public abstract function setFormatter(string $methodName, SessionDataFormatter $ff);

    public abstract function init(string $encodedData);
}