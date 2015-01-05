<?php

namespace League\CLImate\Util\System;

abstract class System
{
    /**
     * @return integer|null
     */

    abstract public function width();

    /**
     * @return integer|null
     */

    abstract public function height();

    /**
     * Check if the stream supports ansi escape characters.
     *
     * @return bool
     */

    abstract public function hasAnsiSupport();

    /**
     * Wraps exec function, allowing the dimension methods to decouple
     *
     * @param string $command
     * @param boolean $full
     *
     * @return string|array
     */
    protected function exec($command, $full = false)
    {
        if ($full) {
            exec($command, $output);

            return $output;
        }

        return exec($command);
    }
}
