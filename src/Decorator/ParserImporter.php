<?php

namespace CLImate\Decorator;

trait ParserImporter
{
    protected $parser;

    /**
     * Import the parser and set the property
     *
     * @param CLImate\Decorator\Parser $parser
     */

    public function parser(Parser $parser)
    {
        $this->parser = $parser;
    }
}
