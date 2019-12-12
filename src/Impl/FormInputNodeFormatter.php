<?php

namespace ClientSessionState\Impl;
use ClientSessionState\Contracts\SessionDataFormatter;

class FormInputNodeFormatter implements SessionDataFormatter
{
    /**
     * outputs the data as an <input> element
     *
     * @param string $input
     * @return mixed
     */
    public function format(string $input, ...$args)
    {
        $inputProps = count($args) ? $args[0] : [];
        $defaultProps = array(
            'name' => 'session_data',
            'id' => 'session_data',
            'type' => 'hidden',
        );
        $properties = array_merge($defaultProps, $inputProps);
        $properties['value'] = $input;
        $output = "<input ";
        foreach ($properties as $name => $val) {
            $output .= \addslashes($name) . " = '" . \addslashes($val) . "' ";
        }
        return $output . "/>";
    }
}