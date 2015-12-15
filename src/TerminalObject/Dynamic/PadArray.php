<?php

namespace League\CLImate\TerminalObject\Dynamic;

class PadArray extends Padding
{

    /**
     * If they pass in a padding character, set the char
     *
     * @param array $data
     * @param string $char The character to use for padding
     */
    public function __construct(array $data, $char = null)
    {
        $data = $this->convertValuesToStrings($data);
        $length = $this->getMaxStringLength(array_keys($data));

        parent::__construct($length, $char);

        foreach ($data as $key => $value) {
            $this->label($key)->result($value);
        }
    }


    /**
     * Convert every key/value in the array to a string
     *
     * @param array $data
     *
     * @return array
     */
    protected function convertValuesToStrings(array $data)
    {
        $strings = [];

        # Convert each element in the array to a string
        foreach ($data as $key => $value) {
            $type = strtolower(gettype($value));
            switch ($type) {
                case 'boolean':
                    $value = $value ? '[true]' : '[false]';
                    break;
                case 'array':
                case 'object':
                case 'resource':
                    $value = '[' . $type . ']';
                    break;
                default:
                    $value = (string) $value;
                    break;
            }

            $key = (string) $key;
            $strings[$key] = $value;
        }

        return $strings;
    }


    /**
     * Get the length of the longest string so we know how much padding we need
     *
     * @param string[] $keys
     *
     * @return int
     */
    protected function getMaxStringLength(array $keys)
    {
        # Default to at least 5 spaces of padding
        $max = 5;

        foreach ($keys as $key) {
            $length = strlen($key);
            if ($length > $max) {
                $max = $length;
            }
        }

        return $max;
    }
}
