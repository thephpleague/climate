<?php

namespace League\CLImate\Util\System;

class Linux implements SystemInterface {

    public function width()
    {
        $width = exec('tput cols');

        return (is_numeric($width)) ? $width : null;
    }

    public function height()
    {
        $height = exec('tput lines');

        return (is_numeric($height)) ? $height : null;
    }

}
