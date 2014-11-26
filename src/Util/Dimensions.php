<?php

namespace League\CLImate\Util;

use League\CLImate\Util\System\SystemFactory;
use League\CLImate\Util\System\SystemInterface;

class Dimensions {

    /**
     * A instance of the class specific to the current system
     *
     * @var \League\CLImate\Util\System\Windows|\League\CLImate\Util\System\Linux
     */
    protected $system;

    public function __construct(SystemInterface $system = null)
    {
        if ($system) {
            $this->system = $system;
        } else {
            $this->system = SystemFactory::getInstance();
        }
    }

    /**
     * Get the width of the terminal
     *
     * @return integer|null
     */
    public function width()
    {
        // Default to standard width as a best guess
        return $this->isNumeric($this->system->width(), 80);
    }

    /**
     * Get the height of the terminal
     *
     * @return integer|null
     */
    public function height()
    {
        // Default to standard height as a best guess
        return $this->isNumeric($this->system->height(), 25);
    }

    /**
     * Determine if the value is numeric, fallback to a default if not
     *
     * @param integer|null $num
     * @param integer $default
     */
    protected function isNumeric($num, $default)
    {
        return (is_numeric($num)) ? $num : $default;
    }
}
