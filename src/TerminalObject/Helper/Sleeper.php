<?php

namespace League\CLImate\TerminalObject\Helper;

class Sleeper implements SleeperInterface
{
    /**
     * The default length of the sleep
     *
     * @var int|float $speed
     */
    protected $speed = 50000;

    /**
     * Set the speed based on a percentage (50% slower, 200% faster, etc)
     *
     * @param int|float $percentage
     *
     * @return float
     */
    public function speed($percentage)
    {
        if (is_numeric($percentage) && $percentage > 0) {
            $this->speed *= (100 / $percentage);
        }

        return $this->speed;
    }

    /**
     * Sleep for the specified amount of time
     */
    public function sleep()
    {
        usleep($this->speed);
    }
}
