<?php

namespace League\CLImate\Decorator;

use League\CLImate\Util\System\SystemFactory;

class ParserFactory
{

    /**
     * Get an instance of the appropriate Parser class
     *
     * @param array $current
     * @param array $all
     * @return League\CLImate\Decorator\Parser
     */

    public static function getInstance(array $current, array $all)
    {
        $system = SystemFactory::getInstance();

        if ($system->hasAnsiSupport()) {
            return new AnsiParser($current, $all);
        }

        return new NonAnsiParser($current, $all);
    }
}
