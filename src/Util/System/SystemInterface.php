<?php

namespace League\CLImate\Util\System;

interface SystemInterface
{
    /**
     * @return integer|null
     */
    public function width();

    /**
     * @return integer|null
     */
    public function height();

    /**
     * Check if the stream supports ansi escape characters.
     *
     * @return bool
     */

    public function hasAnsiSupport();
}
