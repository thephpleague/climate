<?php

namespace League\CLImate\TerminalObject\Router;

class DynamicRouter extends BaseRouter implements RouterInterface {

    /**
     * Determines if the requested class is a
     * valid dynamic terminal object class
     *
     * @param  string  $class
     * @return boolean
     */

    public function exists($class)
    {
        return class_exists($this->path($class));
    }

    /**
     * Get the full path for a dynamic terminal object class
     *
     * @param  string $class
     * @return string
     */

    public function path($class)
    {
        return $this->getPath('Dynamic\\' . $this->shortName($class));
    }

    /**
     * Execute a dynamic terminal object using given arguments
     *
     * @param \League\CLImate\TerminalObject\Dynamic $obj
     */

    public function execute($obj)
    {
        return $obj;
    }

}
