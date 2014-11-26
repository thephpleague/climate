<?php

namespace League\CLImate\Util\System;

class Windows implements SystemInterface
{
    /**
     * Get the width of the terminal
     *
     * @return integer|null
     */
    public function width()
    {
        $dimensions = $this->getDimensions();

        return (!empty($dimensions[1])) ? $dimensions[1] : null;
    }

    /**
     * Get the height of the terminal
     *
     * @return integer|null
     */
    public function height()
    {
        $dimensions = $this->getDimensions();

        return (!empty($dimensions[0])) ? $dimensions[0] : null;
    }

    /**
     * Get information about the dimensions of the terminal
     *
     * @return integer|null
     */
    protected function getDimensions()
    {
        exec('mode', $output);

        if (!is_array($output)) {
            return [];
        }

        $output = implode("\n", $output);

        preg_match_all('/.*:\s*(\d+)/', $output, $matches);

        return (!empty($matches[1])) ? $matches[1] : [];
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
        if (getenv('ANSICON') === true) {
            return true;
        }
        if (getenv('ConEmuANSI') === 'ON') {
            return true;
        }

        return false;
    }
}
