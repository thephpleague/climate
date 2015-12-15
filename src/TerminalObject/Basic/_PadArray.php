<?php

namespace League\CLImate\TerminalObject\Basic;

class PadArray extends BasicTerminalObject
{
    /**
     * The data to convert to JSON
     *
     * @var mixed $data
     */
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Return the data as JSON
     *
     * @return string
     */
    public function result()
    {
        # Default to at least 5 spaces of padding
        $max = 5;

        # Convert each element in the array to a string
        foreach ($this->data as &$value) {
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

            $len = strlen($value);
            if ($len > $max) {
                $max = $len;
            }
        }
        unset($value);

        $padding = new Padding($max);
        $padding->char('-');

        foreach ($this->data as $key => $value) {
            $padding->label($key)->result($value);
        }
    }
}
