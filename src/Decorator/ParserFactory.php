<?php

namespace League\CLImate\Decorator;

use League\CLImate\Util\System\SystemFactory;

class ParserFactory
{
    /**
     * @var ParserInterface $instance
     */

    protected static $instance;

    /**
     * Get an instance of the appropriate Parser class
     *
     * @param array $current
     * @param array $all
     * @return ParserInterface
     */

    public static function getInstance(array $current, array $all)
    {
        if (static::$instance) {
            return static::$instance;
        }

        $system = SystemFactory::getInstance();

        if ($system->hasAnsiSupport()) {
            static::$instance = new AnsiParser($current, $all);
        } else {
            static::$instance = new NonAnsiParser($current, $all);
        }

        return static::$instance;
    }
}
