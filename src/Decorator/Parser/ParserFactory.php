<?php

namespace League\CLImate\Decorator\Parser;

use League\CLImate\Util\System\System;
use League\CLImate\Decorator\Tags;

class ParserFactory
{
    /**
     * Get an instance of the appropriate Parser class
     *
     * @param System $system
     * @param array $current
     * @param Tags $tags
     * @return Parser
     */
    public static function getInstance(System $system, array $current, Tags $tags)
    {
        if ($system->hasAnsiSupport()) {
            return new Ansi($current, $tags);
        }

        return new NonAnsi($current, $tags);
    }
}
