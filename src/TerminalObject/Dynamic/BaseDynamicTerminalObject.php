<?php

namespace CLImate\TerminalObject\Dynamic;

abstract class BaseDynamicTerminalObject {

	protected $cli;

	public function __construct()
	{

    }

    public function cli( \CLImate\CLImate $cli )
    {
    	$this->cli = $cli;

    	$this->cli->style->persistent();
    }

}