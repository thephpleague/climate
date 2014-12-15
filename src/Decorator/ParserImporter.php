<?php

namespace League\CLImate\Decorator;

trait ParserImporter
{
    /**
     * An instance of the Parser class
     *
     * @var \League\CLImate\Decorator\Parser $parser
     */
    protected $parser;

    /**
     * Import the parser and set the property
     *
     * @param \League\CLImate\Decorator\Parser $parser
     */
    public function parser(Parser $parser)
    {
        $this->parser = $parser;
    }
}
