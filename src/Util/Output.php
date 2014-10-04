<?php

namespace League\CLImate\Util;

use League\CLImate\Decorator\Parser;
use League\CLImate\Decorator\ParserImporter;

class Output
{
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

    /**
     * Dictate that a new line should not be added after the output
     */

    public function sameLine()
    {
        $this->new_line = false;

        return $this;
    }

    public function write($content)
    {
        if ($this->new_line) $content .= PHP_EOL;

        fwrite(STDOUT, $content);

        $this->new_line = true;
    }

}
