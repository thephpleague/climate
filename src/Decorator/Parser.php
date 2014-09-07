<?php

namespace CLImate\Decorator;

class Parser
{
    /**
     * An array of the currently applied codes
     *
     * @var array $current;
     */

    protected $current;

    /**
     * All of the possible styles available
     *
     * @var array $all
     */

    protected $all;

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

    public function __construct(array $current, array $all)
    {
        $this->current = $current;
        $this->all     = $all;

        $this->buildTags();
    }

    /**
     * Wrap the string in the current style
     *
     * @param  string $str
     * @return string
     */

    public function apply($str)
    {
        return $this->start() . $this->parse($str) . $this->end();
    }

    /**
     * Get the string that begins the style
     *
     * @param  string $color
     * @return string
     */

    protected function start($style = null)
    {
        $style = $style ?: $this->currentCode();

        return "\e[{$style}m";
    }

    /**
     * Get the string that ends the style
     *
     * @return string
     */

    protected function end()
    {
        return "\e[0m";
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
        $tags   = $this->all;
        $search = [];

        foreach ($tags as $tag => $color) {
            $search["<{$tag}>"]  = $this->start($this->codeStr($color));
            $search["</{$tag}>"] = $this->end();

            // Also replace JSONified end tags
            $search["<\\/{$tag}>"] = $this->end();
        }

        $this->tag_search  = array_keys($search);
        $this->tag_replace = array_values($search);
    }

    /**
     * Stringify the codes
     *
     * @param  mixed  $codes
     * @return string
     */

    protected function codeStr($codes)
    {
        if (!is_array($codes)) $codes = [$codes];

        // For the sake of consistency and testability
        sort($codes);

        return implode(';', $codes);
    }

    /**
     * Retrive the current style code
     *
     * @return string
     */

    protected function currentCode()
    {
        return $this->codeStr($this->current);
    }

}
