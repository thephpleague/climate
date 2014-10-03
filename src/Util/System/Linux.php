<?php

namespace League\CLImate\Util\System;

class Linux implements SystemInterface {

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

}
