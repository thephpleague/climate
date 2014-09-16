<?php

namespace League\CLImate;

use League\CLImate\Decorator\Parser;

class Output
{
    protected $output;

    protected $parser;

    public function __construct($output, Parser $parser)
    {
        $this->output = $output;
        $this->parser = $parser;
    }

    public function __toString()
    {
        return $this->parser->apply($this->output) . "\n";
    }
}
