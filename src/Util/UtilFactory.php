<?php

namespace League\CLImate\Util;

class UtilFactory
{
    /**
     * A instance of the Dimension class
     *
     * @var \League\CLImate\Util\Dimensions
     */

    public $dimensions;

    /**
     * A instance of the Cursor class
     *
     * @var \League\CLImate\Util\Cursor
     */

    public $cursor;

    public function __construct()
    {
        $this->dimensions = new Dimensions();
        $this->cursor     = new Cursor();
    }

}
