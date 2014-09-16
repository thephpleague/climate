<?php

namespace League\CLImate\Decorator;

/**
 * @method void addColor(string $color, integer $code)
 * @method void addFormat(string $format, integer $code)
 * @method void addCommand(string $command, mixed $style)
 */

class Style
{

    /**
     * An array of Decorator objects
     *
     * @var array $style
     */

    protected $style = [];

    /**
     * An array of the available Decorators
     * and their corresponding class names
     *
     * @var array $available
     */

    protected $available = [
        'format'     =>  'Format',
        'color'      =>  'Color',
        'background' =>  'BackgroundColor',
        'command'    =>  'Command',
    ];

    /**
     * An array of the current styles applied
     *
     * @var array $current
     */

    protected $current = [];

    public function __construct()
    {
        foreach ($this->available as $key => $class) {
            $class = '\\League\CLImate\\Decorator\\' . $class;
            $this->style[$key] = new $class();
        }
    }

    /**
     * Get all of the styles available
     *
     * @return array
     */

    public function all()
    {
        $all = [];

        foreach ($this->style as $style) {
            $all = array_merge($all, $this->convertToCodes($style->all()));
        }

        return $all;
    }

    /**
     * Attempt to get the corresponding code for the style
     *
     * @param  mixed $key
     * @return mixed
     */

    public function get($key)
    {
        foreach ($this->style as $style) {
            $code = $style->get($key);
            if ($code) return $code;
        }

        return false;
    }

    /**
     * Attempt to set some aspect of the styling,
     * return true if attempt was successful
     *
     * @param  string   $key
     * @return boolean
     */

    public function set($key)
    {
        foreach ($this->style as $style) {

            $code = $style->set($key);

            if ($code) {
                // If we have something but it's not an integer,
                // plug it back in and see what we get
                if (is_string($code)) {
                    return $this->set($code);

                // If we got an array back, loop through it
                // and add each of the properties
                } elseif (is_array($code)) {
                    $adds = [];

                    foreach ($code as $c) {
                        $adds[] = $this->set($c);
                    }

                    // If any of them came back true, we're good to go
                    return in_array(true, $adds);
                }

                return true;
            }
        }

        return false;
    }

    /**
     * Reset the current styles applied
     *
     */

    public function reset()
    {
        foreach ($this->style as $style) {
            $style->reset();
        }
    }

    /**
     * Get a new instance of the Parser class based on the current settings
     *
     * @return Parser
     */

    public function parser()
    {
        return new Parser($this->current(), $this->all());
    }

    /**
     * Compile an array of the current codes
     *
     * @return array
     */

    public function current()
    {
        $full_current = [];

        foreach ($this->style as $style) {
            $current = $style->current();

            if (!is_array($current)) $current = [$current];

            $full_current = array_merge($full_current, $current);
        }

        $full_current = array_filter($full_current);

        return array_values($full_current);
    }

    protected function convertToCodes(array $codes)
    {
        foreach ($codes as $key => $code) {
            if (is_int($code)) continue;
            if (is_array($code)) {
                foreach ($code as $code_key => $c) {
                    $codes[$key][$code_key] = $this->get($c);
                }
            } else {
                $codes[$key] = $this->get($code);
            }
        }

        return $codes;
    }

    /**
     * Magic Methods
     *
     * List of possible magic methods are at the top of this class
     *
     * @param string $requested_method
     * @param array  $arguments
     */

    public function __call($requested_method, $arguments)
    {
        // The only methods we are concerned about are 'add' methods
        if (substr($requested_method, 0, 3) == 'add') {

            $style = substr($requested_method, 3, strlen($requested_method));
            $style = strtolower($style);

            if (array_key_exists($style, $this->style)) {

                list($key, $value) = $arguments;

                $this->style[$style]->add($key, $value);

                // If we are adding a color, make sure it gets added
                // as a background color too
                if ($style == 'color') {
                    $this->style['background']->add($key, $value);
                }
            }
        }
    }

}
