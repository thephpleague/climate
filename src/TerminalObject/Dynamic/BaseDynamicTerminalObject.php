<?php

namespace CLImate\TerminalObject\Dynamic;

use CLImate\Decorator\Parser;

abstract class BaseDynamicTerminalObject
{
    protected $style;

    public function __construct()
    {

    }

    /**
     * Set the cli property and persist the style
     *
     * @param CLImate\CLImate $cli
     */

    public function style(Parser $style)
    {
        $this->style = $style;
    }

}
