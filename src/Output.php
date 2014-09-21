<?php

namespace League\CLImate;

use League\CLImate\Decorator\ParserImporter;
use League\CLImate\Decorator\Parser;

class Output
{
    use ParserImporter;

    /**
     * The content to be output
     *
     * @var string $content
     */

    protected $content;

    /**
     * Whether or not to add a new line after the output
     *
     * @var boolean $new_line
     */

    protected $new_line = true;

    public function __construct($content, Parser $parser)
    {
        $this->parser($parser);
        $this->content($content);
    }

    /**
     * Set the cotent to be output
     *
     * @param  string $content
     */

    protected function content($content)
    {
        $this->content = $content;
    }

    /**
     * Dictate that a new line should not be added after the output
     */

    public function sameLine()
    {
        $this->new_line = false;
    }

    /**
     * If the class is output as a string, this triggers,
     * applying the appropriate styles and adding a new line if necessary
     *
     * @return string
     */

    public function __toString()
    {
        $result = $this->parser->apply($this->content);

        if ($this->new_line) $result .= "\n";

        return $result;
    }
}
