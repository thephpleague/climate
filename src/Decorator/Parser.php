<?php

namespace League\CLImate\Decorator;

abstract class Parser
{
    /**
     * An array of the currently applied codes
     *
     * @var array $current;
     */
    protected $current = [];

    /**
     * All of the possible styles available
     *
     * @var array $all
     */
    protected $all = [];

    /**
     * An array of the tags that should be searched for
     * and their corresponding replacements
     *
     * @var array $tags
     */
    public $tags  = [];

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
    abstract public function apply($str);

    /**
     * Get the regular expression that can be used to parse the string for tags
     *
     * @return string
     */

    protected function getRegexForTags()
    {
        return '(<(?:(?:(?:\\\)*\/)*(?:' . implode('|', array_keys($this->all)) . '))>)';
    }

    /**
     * Build the search and replace for all of the various style tags
     */
    protected function buildTags()
    {
        $tags       = $this->all;
        $this->tags = [];

        foreach ($tags as $tag => $color) {
            $this->tags["<{$tag}>"]    = $color;
            $this->tags["</{$tag}>"]   = $color;
            $this->tags["<\\/{$tag}>"] = $color;
        }
    }
}
