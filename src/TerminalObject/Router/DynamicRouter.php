<?php

namespace League\CLImate\TerminalObject\Router;

class DynamicRouter extends BaseRouter implements RouterInterface {

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
