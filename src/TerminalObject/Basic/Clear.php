<?php

namespace League\CLImate\TerminalObject\Basic;

class Clear extends BasicTerminalObject
{
    /**
     * Clear the terminal
     *
     * @return string
     */
    public function result()
    {
        return "\e[H\e[2J";
    }

    public function sameLine()
    {
        return true;
    }
}
