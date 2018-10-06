<?php

namespace League\CLImate\TerminalObject\Dynamic;

use function strtolower;
use function substr;

class Confirm extends Input
{
    /**
     * Let us know if the user confirmed.
     *
     * @return bool
     */
    public function confirmed()
    {
        $this->prompt .= " [y/N]";
        $this->default = "n";

        $this->accept(['y', 'yes', 'n', 'no'], false);

        $response = strtolower($this->prompt());

        return (substr($response, 0, 1) === 'y');
    }
}
