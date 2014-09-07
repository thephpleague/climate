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
     * An array of the tags that should be searched for
     *
     * @var array $tag_search
     */

    public $tag_search  = [];

    /**
     * A corresponding array of the codes that should be
     * replaced with the $tag_search
     *
     * @var array $tag_replace
     */

    public $tag_replace = [];

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
     * Get the string that begins the style
     *
     * @param  string $color
     * @return string
     */

    public function start($style = null)
    {
        $style = $style ?: $this->currentCode();

        return "\e[{$style}m";
    }

    /**
     * Get the string that ends the style
     *
     * @return string
     */

    public function end()
    {
        return "\e[0m";
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

    /**
     * Wrap the string in the current style
     *
     * @param  string $str
     * @return string
     */

    public function apply($str)
    {
        $str = $this->parse($str);

        return $this->start() . $str . $this->end();
    }

    /**
     * Parse the string for tags and replace them with their codes
     *
     * @param  string $str
     * @return string
     */

    protected function parse($str)
    {
        return str_replace($this->tagSearch(), $this->tagReplace(), $str);
    }

    /**
     * Retrieve the array of searchable tags
     *
     * @return array
     */

    protected function tagSearch()
    {
        return $this->tag_search;
    }

    /**
     * Retrieve an array of tag replacements
     *
     * @return array
     */

    protected function tagReplace()
    {
        $start_code = $this->start($this->currentCode());

        return array_map(function ($item) use ($start_code) {
            // We have to re-start the parent style after each tag is replaced
            if ($item == $this->end()) {
                return $item . $start_code;
            }

            return $item;
        }, $this->tag_replace);
    }

    /**
     * Build the search and replace for all of the various style tags
     */

    protected function buildTags()
    {
        $tags   = $this->all();
        $search = [];

        foreach ($tags as $tag => $color) {
            $search["<{$tag}>"]  = $this->start($color);
            $search["</{$tag}>"] = $this->end();

            // Also replace JSONified end tags
            $search["<\\/{$tag}>"] = $this->end();
        }

        $this->tag_search  = array_keys($search);
        $this->tag_replace = array_values($search);
    }

    /**
     * Retrive the current style code
     *
     * @return string
     */

    protected function currentCode()
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

        return implode(';', $full_current);
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
