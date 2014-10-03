<?php

namespace League\CLImate\Util\System;

class Windows implements SystemInterface {

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

        $output = implode("\n", $output);

        preg_match_all('/.*:\s*(\d+)/', $output, $matches);

        return (!empty($matches[1])) ? $matches[1] : [];
    }

}
