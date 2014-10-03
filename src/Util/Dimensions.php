<?php

namespace League\CLImate\Util;

use League\CLImate\Util\System\Linux;
use League\CLImate\Util\System\Windows;

class Dimensions {

    protected $system;

    public function __construct()
    {
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            $this->system = new Windows();
        } else {
            $this->system = new Linux();
        }
    }

    public function width()
    {
        // Default to standard width as a best guess
        return $this->isNumeric($this->system->width(), 80);
    }

    public function height()
    {
        // Default to standard height as a best guess
        return $this->isNumeric($this->system->height(), 25);
    }

    protected function isNumeric($num, $default)
    {
        return (is_numeric($num)) ? $num : $default;
    }

}
