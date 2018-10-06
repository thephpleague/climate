<?php

namespace League\CLImate\TerminalObject\Dynamic;

class Confirm extends Input
{
    /**
     * Let us know if the user confirmed
     *
     * @return boolean
     */
    public function confirmed()
    {
        $this->prompt = $this->prompt . ' [y/n]';

        $this->accept(['y', 'yes', 'n', 'no'], false);

        $response = \strtolower($this->prompt());
        return (substr($response, 0, 1) === 'y');
    }
}
