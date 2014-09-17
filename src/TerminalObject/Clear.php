<?php

namespace League\CLImate\TerminalObject;

class Clear extends BaseTerminalObject
{
    /**
     * Clear the terminal
     *
     * @return string
     */

    public function result()
    {
        return "\e[2J";
    }
}
