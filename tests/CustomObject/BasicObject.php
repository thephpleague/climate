<?php

namespace League\CLImate\Tests\CustomObject;

use League\CLImate\TerminalObject\Basic\BasicTerminalObject;

class BasicObject extends BasicTerminalObject
{
    public function result()
    {
        return 'This just outputs this.';
    }
}
