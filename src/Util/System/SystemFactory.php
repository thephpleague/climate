<?php

namespace League\CLImate\Util\System;

class SystemFactory
{
    /**
     * @var SystemInterface $instance An instance of the system class for the operating system we are running on
     */
    protected static $instance;

    /**
     * Get an instance of the appropriate System class
     *
     * @return SystemInterface
     */
    public static function getInstance()
    {
        if (static::$instance) {
            return static::$instance;
        }

        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            static::$instance = new Windows();
        } else {
            static::$instance = new Linux();
        }

        return static::$instance;
    }
}
