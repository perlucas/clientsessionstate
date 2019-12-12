<?php

namespace ClientSessionState;
use ClientSessionState\Contracts\SessionDataFormatter;

/**
 * manages the distinct output formats
 */
class SessionDataFormatterInvoker
{
    /**
     * encoded session data to be outputted
     *
     * @var string
     */
    protected $encodedData;

    /**
     * map for containing the formatter's
     *
     * @var array
     */
    protected $formatterMap;

    /**
     * constructs an empty instance
     */
    public function __construct()
    {
        $this->encodedData = null;
        $this->formatterMap = array();
    }

    /**
     * setter for the encoded data
     *
     * @param string $enc
     * @return void
     */
    public function setEncodedSession(string $enc)
    {
        $this->encodedData = $enc;
    }

    /**
     * saves a formatter on the map
     *
     * @param string $callThis - method name for invoking the formatter
     * @param SessionDataFormatter $formatter
     * @return void
     */
    public function setFormatter(string $callThis, SessionDataFormatter $formatter)
    {
        $this->formatterMap[$callThis] = $formatter;
    }

    /**
     * magic method for handling the invoking of formatters
     *
     * @param string $methodName
     * @param array $arguments
     * @return mixed
     */
    public function __call(string $methodName, array $arguments)
    {
        if (!\array_key_exists($methodName, $this->formatterMap)) {
            throw new RuntimeException("Method {$methodName} not defined!", 1);
        }
        $ff = $this->formatterMap[$methodName];
        \array_unshift($arguments, $this->encodedData);
        return \call_user_func_array([$ff, 'format'], $arguments);
    }
}