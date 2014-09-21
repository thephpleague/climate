<?php

namespace League\CLImate;

use League\CLImate\Decorator\ParserImporter;
use League\CLImate\Decorator\Parser;

class Output
{
    use ParserImporter;

    protected $content;

    protected $new_line = true;

    public function __construct($content, Parser $parser)
    {
        $this->parser($parser);
        $this->content($content);
    }

    protected function content($content)
    {
        $this->content = $content;
    }

    public function sameLine()
    {
        $this->new_line = false;
    }

    public function __toString()
    {
        $result = $this->parser->apply($this->content);

        if ($this->new_line) $result .= "\n";

        return $result;
    }
}
