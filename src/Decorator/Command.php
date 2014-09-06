<?php

namespace CLImate\Decorator;

class Command extends BaseDecorator
{

    /**
     * Commands that correspond to a color in the $colors property
     *
     * @var array
     */

    public $commands = [];

    protected $defaults = [
            'info'    => 'green',
            'comment' => 'yellow',
            'whisper' => 'light_gray',
            'shout'   => 'red',
            'error'   => 'light_red',
        ];

    public function add($key, $value)
    {
        $this->commands[$key] = $value;
    }

    public function all()
    {
        return $this->commands;
    }

    /**
     * Get the style that corresponds to the command
     *
     * @param  mixed $val
     * @return string
     */

    public function get($val)
    {
        if (array_key_exists($val, $this->commands)) {
            return $this->commands[$val];
        }

        return null;
    }

    public function set($val)
    {
        $code = $this->get($val);

        if ($code) {
            return $code;
        }

        return false;
    }

}
