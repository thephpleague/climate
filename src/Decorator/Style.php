<?php

namespace CLImate\Decorator;

class Style
{

    protected $style = [];

    protected $available = [
        'format'     =>  'Format',
        'color'      =>  'Color',
        'background' =>  'BackgroundColor',
        'command'    =>  'Command',
    ];

    /**
     * An array of the current styles applied
     *
     * @var array
     */

    protected $current = [];

    /**
     * An array of the tags that should be searched for
     *
     * @var array
     */

    public $tag_search  = [];

    /**
     * A corresponding array of the codes that should be
     * replaced with the $tag_search
     *
     * @var array
     */

    public $tag_replace = [];

    protected $persist = false;

    public function __construct()
    {
        foreach ($this->available as $key => $class) {
            $class = '\\CLImate\\Decorator\\' . $class;
            $this->style[$key] = new $class;
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

    public function all()
    {
        $all = [];

        foreach ($this->style as $style) {
            $all = array_merge($all, $style->all());
        }

        return $all;
    }

    public function set($key)
    {
        foreach ($this->style as $style) {
            $code = $style->set($key);
            if ($code) {

                if (is_string($code)) {
                    return $this->set($code);
                }

                return true;
            }
        }

        return false;
    }

    public function reset($force = false)
    {
        if (!$this->persist || ($this->persist && $force)) {
            foreach ($this->style as $style) {
                $style->reset();
            }
        }
    }

    /**
     * Retrieve the array of searchable tags
     *
     * @return array
     */

    public function tagSearch()
    {
        return $this->tag_search;
    }

    /**
     * Retrieve an array of tag replacements
     *
     * @return array
     */

    public function tagReplace()
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
     * Set all of the current properties to be consistent
     */

    public function persist()
    {
        $this->persist = true;
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

    public function __call($requested_method, $arguments)
    {
        if (substr($requested_method, 0, 3) == 'add') {

            $style = substr($requested_method, 3, strlen($requested_method));
            $style = strtolower($style);

            if (array_key_exists($style, $this->style)) {

                list($key, $value) = $arguments;
                $this->style[$style]->add($key, $value);

                if ($style == 'color') {
                    $this->style['background']->add($key, $value);
                }

                $this->buildTags();
            }
        }
    }

}
