<?php

namespace League\CLImate\Tests\CustomObject;

use League\CLImate\TerminalObject\Basic\BasicTerminalObject;

class Basic extends BasicTerminalObject
{
    protected $content;

    public function __construct($content)
    {
        $this->content = $content;
    }

    public function result()
    {
        return 'By Custom Object: ' . $this->content;
    }
}
