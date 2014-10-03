<?php

namespace League\CLImate\Util\System;

class Windows implements SystemInterface {

    public function width()
    {
        $dimensions = $this->getDimensions();

        return (!empty($dimensions[1])) ? $dimensions[1] : null;
    }

    public function height()
    {
        $dimensions = $this->getDimensions();

        return (!empty($dimensions[0])) ? $dimensions[0] : null;
    }

    protected function getDimensions()
    {
        $info = exec('mode');

        preg_match_all('/.*:\s*(\d+)/', $info, $matches);

        return (!empty($matches[1])) ? $matches[1] : [];
    }

}
