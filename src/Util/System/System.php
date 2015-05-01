<?php

namespace League\CLImate\Util\System;

abstract class System
{
    protected $force_ansi;

    /**
     * Force ansi on or off
     *
     * @param bool $force
     */
    public function forceAnsi($force = true)
    {
        $this->force_ansi = $force;
    }

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
    abstract protected function systemHasAnsiSupport();

    /**
     * Check if we are forcing ansi, fallback to system support
     *
     * @return bool
     */
    public function hasAnsiSupport()
    {
        if (is_bool($this->force_ansi)) {
            return $this->force_ansi;
        }

        return $this->systemHasAnsiSupport();
    }

    /**
     * Wraps exec function, allowing the dimension methods to decouple
     *
     * @param string $command
     * @param boolean $full
     *
     * @return string|array
     */
    public function exec($command, $full = false)
    {
        if ($full) {
            exec($command, $output);

            return $output;
        }

        return exec($command);
    }
}
