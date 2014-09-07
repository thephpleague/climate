<?php

namespace CLImate\Decorator;

class Format extends BaseDecorator
{

    /**
     * The available formatting options
     *
     * @var array
     */

    protected $formats = [];

    protected $defaults = [
            'bold'          => 1,
            'dim'           => 2,
            'underline'     => 4,
            'blink'         => 5,
            'invert'        => 7,
            'hidden'        => 8,
        ];

    public function add($key, $value)
    {
        $this->formats[$key] = $value;
    }

    public function all()
    {
        return $this->formats;
    }

    /**
     * Get the code for the format
     *
     * @param  mixed  $val
     * @return string
     */

    public function get($val)
    {
        // If we already have the code, just return that
        if (is_numeric($val)) {
            return $val;
        }

        if (array_key_exists($val, $this->formats)) {
            return $this->formats[$val];
        }

        return null;
    }

    public function set($val)
    {
        $code = $this->get($val);

        if ($code) {
            $this->current[] = $code;

            return true;
        }

        return false;
    }

}
