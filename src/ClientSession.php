<?php

namespace ClientSessionState;
use ClientSessionState\Contracts\Encrypter;
use ClientSessionState\Contracts\Serializer;
use ClientSessionState\Impl\RawStringFormatter;
use ClientSessionState\Impl\FormInputNodeFormatter;
use ClientSessionState\Impl\BasicPHPSerializer;
use ClientSessionState\Impl\DefaultEncrypter;

/**
 * main facade for using the library
 */
abstract class ClientSession
{
    /**
     * session data storage
     *
     * @var array - key/value pairs
     */
    protected $storage;

    /**
     * key to be used for encrypter
     *
     * @var string
     */
    protected $encodingKey = null;

    /**
     * encrypter to be used
     *
     * @var Encrypter
     */
    protected $encrypter;

    /**
     * serializer to be used
     *
     * @var Serializer
     */
    protected $serializer;

    /**
     * invoker for handling the output formats
     *
     * @var SessionDataFormatterInvoker
     */
    protected $outputManager;

    /**
     * instance holder for singleton
     *
     * @var ClientSession
     */
    protected static $instance = null;

    /**
     * constructor for singleton
     */
    protected function __construct()
    {
        $this->storage = array();
        $this->encrypter = $this->createEncrypter();
        $this->serializer = $this->createSerializer();
        $this->outputManager = new SessionDataFormatterInvoker();
        $this->setUpFormatters();
    }

    /**
     * instance accesor
     *
     * @return ClientSession
     */
    public static function instance()
    {
        if (!static::$instance) {
            static::$instance = new static();
        }
        return static::$instance;
    }

    /**
     * creates an encrypter instance to be used
     *
     * @return Encrypter
     */
    protected function createEncrypter(): Encrypter
    {
        return new DefaultEncrypter;
    }

    /**
     * creates a serializer instance to be used
     *
     * @return Serializer
     */
    protected function createSerializer(): Serializer
    {
        return new BasicPHPSerializer;
    }

    /**
     * sets the output formatters provided by default
     *
     * @return void
     */
    protected function setUpFormatters()
    {
        $this->setFormatter('string', new RawStringFormatter);
        $this->setFormatter('input', new FormInputNodeFormatter);
    }

    /**
     * saves a value on the session storage
     *
     * @param string $sessionKey
     * @param mixed $data
     * @return void
     */
    public function set(string $sessionKey, mixed $data)
    {
        $this->storage[$sessionKey] = $data;
    }
    
    /**
     * gets a value from the session data
     * or null if the key is not set
     *
     * @param string $sessionKey
     * @return mixed
     */
    public function get(string $sessionKey): mixed
    {
        if ($this->has($sessionKey)) return $this->storage[$sessionKey];
        return null;
    }
    
    /**
     * returns true if the key is set
     *
     * @param string $sessionKey
     * @return boolean
     */
    public function has(string $sessionKey): boolean
    {
        return \array_key_exists($sessionKey, $this->storage);
    }
    
    /**
     * removes a key from the storage and returns the value
     *
     * @param string $sessionKey
     * @return mixed
     */
    public function remove(string $sessionKey)
    {
        if ($this->has($sessionKey)) {
            $val = $this->storage[$sessionKey];
            unset($this->storage[$sessionKey]);
            return $val;
        }
    }

    /**
     * sets up the encoding key to be used by the encrypter
     *
     * @param string $key
     * @return void
     */
    public function setEncodingKey(string $key)
    {
        $this->encodingKey = $key;
    }

    /**
     * returns the output format handler
     *
     * @return SessionDataFormatterInvoker
     */
    public function output(): SessionDataFormatterInvoker
    {
        $this->outputManager->setEncodedSession($this->encodeData());
        return $this->outputManager;
    }

    /**
     * sets a new formatter
     *
     * @param string $methodName
     * @param SessionDataFormatter $ff
     * @return void
     */
    public function setFormatter(string $methodName, SessionDataFormatter $ff)
    {
        $this->outputManager->setFormatter($methodName, $ff);
    }

    /**
     * loads the session data from the encoded string
     *
     * @param string $encodedData
     * @return void
     */
    public function load(string $encodedData)
    {
        $encodedData = \stripslashes($encodedData);
        $serialized = $this->encrypter->decrypt($this->encodingKey, $encodedData);
        $this->storage = $this->serializer->deserialize($serialized);
    }

    /**
     * encodes the data and returns the string representation
     *
     * @return string
     */
    protected function encodeData()
    {
        $ss = $this->serializer->serialize($this->storage);
        return $this->encrypter->encrypt($this->encodingKey, $ss);
    }
}