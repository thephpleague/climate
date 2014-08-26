<?php

namespace JoeTannenbaum\CLImate\TerminalObject\Dynamic;

abstract class BaseDynamicTerminalObject {

	protected $cli;

	public function __construct()
	{

    }

    public function cli( \JoeTannenbaum\CLImate\CLImate $cli )
    {
    	$this->cli = $cli;

    	$this->cli->style->persistent();
    }

}