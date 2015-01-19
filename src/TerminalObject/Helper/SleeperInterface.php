<?php

namespace League\CLImate\TerminalObject\Helper;

interface SleeperInterface
{
    /**
     * @param int|float $percentage
     */
    public function speed($percentage);

    public function sleep();
}
