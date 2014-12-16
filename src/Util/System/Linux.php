<?php

namespace League\CLImate\Util\System;

class Linux implements SystemInterface
{
    /**
     * Get the width of the terminal
     *
     * @return integer|null
     */
    public function width()
    {
        $width = exec('tput cols');

        return (is_numeric($width)) ? $width : null;
    }

    /**
     * Get the height of the terminal
     *
     * @return integer|null
     */
    public function height()
    {
        $height = exec('tput lines');

        return (is_numeric($height)) ? $height : null;
    }

    /**
     * Check if the stream supports ansi escape characters.
     *
     * Based on https://github.com/symfony/symfony/blob/master/src/Symfony/Component/Console/Output/StreamOutput.php
     *
     * @return bool
     */

    public function hasAnsiSupport()
    {
        return function_exists('posix_isatty') && @posix_isatty(STDOUT);
    }
}
