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

    protected function start($codes = null)
    {
        $codes = $codes ?: $this->currentCode();
        $codes = $this->codeStr($codes);

        return $this->wrapCodes($codes);
    }

    /**
     * Get the string that ends the style
     *
     * @return string
     */

    protected function end($codes = null)
    {
        if (empty($codes)) {
            $codes = [0];
        } else {
            if (!is_array($codes)) $codes = [$codes];
            // Reset everything back to normal up front
            array_unshift($codes, 0);
        }

        return $this->wrapCodes($this->codeStr($codes));
    }

    /**
     * Wrap the code string in the full escaped sequence
     *
     * @param  string $codes
     * @return string
     */

    protected function wrapCodes($codes)
    {
        return "\e[{$codes}m";
    }

    /**
     * Parse the string for tags and replace them with their codes
     *
     * @param  string $str
     * @return string
     */

    protected function parse($str)
    {
        $regex = '(<(?:(?:(?:\\\)*\/)*(?:' . implode('|', array_keys($this->all)) . '))>)';
        $count = preg_match_all($regex, $str, $matches);

        // If we didn't find anything, return the string right back
        if (!$count) return $str;

        // All we want is the array of actual strings matched
        $matches = reset($matches);

        // Let's keep a history of styles applied
        $history = [$this->currentCode()];
        $history = array_filter($history);

        // We will be replacing tags one at a time
        $replace_count = 1;

        foreach ($matches as $match) {
            if (strstr($match, '/')) {
                // We are closing out the tag, pop off the last element and get the codes that are left
                array_pop($history);
                $str = str_replace($match, $this->end($history), $str, $replace_count);
            } else {
                // We are starting a new tag

                // Add it onto the history
                $history[] = $this->tags[$match];

                // Replace the tag with the correct color code
                $str = str_replace($match, $this->start($this->tags[$match]), $str, $replace_count);
            }
        }

        return $str;
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

    /**
     * Stringify the codes
     *
     * @param  mixed  $codes
     * @return string
     */

    protected function codeStr($codes)
    {
        // If we get something that is already a code string, just pass it back
        if (!is_array($codes) && strstr($codes, ';')) return $codes;

        if (!is_array($codes)) $codes = [$codes];

        // Sort for the sake of consistency and testability
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
