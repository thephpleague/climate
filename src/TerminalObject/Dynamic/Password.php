<?php

namespace League\CLImate\TerminalObject\Dynamic;

class Password extends Input
{
    public function prompt()
    {
        $this->writePrompt();

        $response = $this->valueOrDefault($this->reader->hidden());

        if ($this->isValidResponse($response)) {
            return $response;
        }

        return $this->prompt();
    }
}
