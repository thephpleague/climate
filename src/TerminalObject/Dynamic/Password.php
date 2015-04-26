<?php

namespace League\CLImate\TerminalObject\Dynamic;

class Password extends Input
{
    public function prompt()
    {
        $this->hideResponse();

        return parent::prompt();
    }
}
