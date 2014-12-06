<?php

namespace League\CLImate\Util;

use League\CLImate\Util\System\SystemFactory;
use League\CLImate\Util\System\SystemInterface;

class UtilFactory
{
    /**
     * A instance of the appropriate System class
     *
     * @var \League\CLImate\Util\System\SystemInterface
     */

    public $system;

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

    public function __construct(SystemInterface $system = null, Dimensions $dimensions = null, Cursor $cursor = null)
    {
        $this->system     = $system ?: SystemFactory::getInstance();
        $this->dimensions = $dimensions ?: new Dimensions($this->system);
        $this->cursor     = $cursor ?: new Cursor();
    }
}
