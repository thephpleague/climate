<?php

namespace League\CLImate\Argument;

interface ParserInterface
{
    /**
     * Parse command line arguments into CLImate arguments.
     *
     * @throws \Exception if required arguments aren't defined.
     * @param array $argv
     */
    public function parse(array $argv = null);
}
