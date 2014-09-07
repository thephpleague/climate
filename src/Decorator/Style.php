<?php

namespace CLImate\Decorator;

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

    /**
     * A flag for if we are currently persisting styles
     * (i.e. if we should ignore any style resets)
     *
     * @var boolean $persist
     */

    protected $persist = false;

    public function __construct()
    {
        foreach ($this->available as $key => $class) {
            $class = '\\CLImate\\Decorator\\' . $class;
            $this->style[$key] = new $class();
        }

        $this->buildTags();
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
            $all = array_merge($all, $style->all());
        }

        return $all;
    }

    /**
     * Attempt to set some aspect of the styling,
     * return true if attempt was successful
     *
     * @param  mixed   $key
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
                }

                return true;
            }
        }

        return false;
    }

    /**
     * Reset the current styles applied
     *
     * @param boolean $force If we should reset even if persisting
     */

    public function reset($force = false)
    {
        if (!$this->persist || ($this->persist && $force)) {
            foreach ($this->style as $style) {
                $style->reset();
            }
        }
    }

    /**
     * Set all of the current properties to be consistent
     * and ignore any resets
     */

    public function persist()
    {
        $this->persist = true;
    }

    public function parser()
    {
        return new Parser($this->current(), $this->all());
    }

    public function current()
    {
        $full_current = [];

        foreach ($this->style as $style) {

            $current = $style->current();

            if (!is_array($current)) {
                $current = [$current];
            }

            $full_current = array_merge($full_current, $current);
        }

        $full_current = array_filter($full_current);

        return array_values($full_current);
    }

    /**
     * Magic Methods
     *
     * List of possible magic methods are at the top of this class
     *
     * @param string $requested_methods
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

                // We've added something, so let's re-build the tags
                $this->buildTags();
            }
        }
    }

}
