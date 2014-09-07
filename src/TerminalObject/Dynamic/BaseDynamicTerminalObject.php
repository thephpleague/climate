<?php

namespace CLImate\TerminalObject\Dynamic;

use CLImate\CLImate;

abstract class BaseDynamicTerminalObject
{
    protected $cli;

    public function __construct()
    {

    }

    /**
     * Set the cli property and persist the style
     *
     * @param CLImate\CLImate $cli
     */

    public function cli(CLImate $cli)
    {
        $this->cli = $cli;

        $this->cli->style->persist();
    }

}
