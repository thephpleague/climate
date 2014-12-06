<?php

namespace League\CLImate\Decorator\Parser;

use League\CLImate\Util\System\SystemFactory;
use League\CLImate\Decorator\Tags;

class ParserFactory
{

    /**
     * Get an instance of the appropriate Parser class
     *
     * @param array $current
     * @param array $tags
     * @return League\CLImate\Decorator\Parser
     */

    public static function getInstance(array $current, Tags $tags)
    {
        $system = SystemFactory::getInstance();

        if ($system->hasAnsiSupport()) {
            return new Ansi($current, $tags);
        }

        return new NonAnsi($current, $tags);
    }
}
