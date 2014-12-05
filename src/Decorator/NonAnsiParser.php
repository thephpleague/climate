<?php

namespace League\CLImate\Decorator;

class NonAnsiParser extends Parser
{
    /**
     * Strip the string of any tags
     *
     * @param  string $str
     * @return string
     */

    public function apply($str)
    {
        return preg_replace($this->getRegexForTags(), '', $str);
    }
}
