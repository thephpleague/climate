<?php

namespace League\CLImate\Decorator;

class Tags {

    protected $tags = [];

    protected $keys = [];

    public function __construct(array $keys)
    {
        $this->keys = $keys;

        $this->build();
    }

    public function all()
    {
        return $this->tags;
    }

    public function value($key)
    {
        return (array_key_exists($key, $this->tags)) ? $this->tags[$key] : null;
    }

    /**
     * Get the regular expression that can be used to parse the string for tags
     *
     * @return string
     */

    public function regex()
    {
        return '(<(?:(?:(?:\\\)*\/)*(?:' . implode('|', array_keys($this->keys)) . '))>)';
    }

    /**
     * Build the search and replace for all of the various style tags
     */

    protected function build()
    {
        foreach ($this->keys as $tag => $code) {
            $this->tags["<{$tag}>"]    = $code;
            $this->tags["</{$tag}>"]   = $code;
            $this->tags["<\\/{$tag}>"] = $code;
        }
    }

}
