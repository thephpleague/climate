<?php

namespace League\CLImate\Util;

class UtilFactory {

    /**
     * A instance of the Dimension class
     *
     * @var \League\CLImate\Util\Dimensions
     */

    public $dimensions;

    public function __construct()
    {
        $this->dimensions = new Dimensions();
    }

}
