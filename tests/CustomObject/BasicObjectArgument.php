<?php

namespace League\CLImate\Tests\CustomObject;

use League\CLImate\TerminalObject\Basic\BasicTerminalObject;

class BasicObjectArgument extends BasicTerminalObject
{
    protected $content;

    public function arguments($content)
    {
        $this->content = $content;
    }

    public function result()
    {
        return 'Hey: ' . $this->content;
    }
}
