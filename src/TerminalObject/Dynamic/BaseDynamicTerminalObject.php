<?php

namespace CLImate\TerminalObject\Dynamic;

use CLImate\CLImate;

abstract class BaseDynamicTerminalObject
{
    protected $cli;

    public function __construct()
    {

    }

    public function cli(CLImate $cli)
    {
        $this->cli = $cli;

        $this->cli->style->persist();
    }

}
