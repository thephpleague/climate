<?php

namespace CLImate\Decorator;

trait ParserImporter
{
    /**
     * An instance of the Parser class
     *
     * @var \CLImate\Decorator\Parser $parser
     */

    protected $parser;

    /**
     * Import the parser and set the property
     *
     * @param \CLImate\Decorator\Parser $parser
     */

    public function parser(Parser $parser)
    {
        $this->parser = $parser;
    }
}
