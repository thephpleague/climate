<?php

namespace League\CLImate\TerminalObject\Router;

abstract class BaseRouter {

    /**
     * Get the full path for the terminal object class
     *
     * @param  string $class
     * @return string
     */

    protected function getPath($class)
    {
        return '\League\CLImate\TerminalObject\\' . $class;
    }

    /**
     * Get the class short name
     *
     * @param string $name
     * @return string
     */

    protected function shortName($name)
    {
        $name = str_replace('_', ' ', $name);
        $name = ucwords($name);

        return str_replace(' ', '', $name);
    }

}
