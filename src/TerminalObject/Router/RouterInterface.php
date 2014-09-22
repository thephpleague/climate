<?php

namespace League\CLImate\TerminalObject\Router;

interface RouterInterface {

    public function path($class);

    public function exists($class);

    public function execute($obj);

}
