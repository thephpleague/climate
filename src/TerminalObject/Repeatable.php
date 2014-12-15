<?php

namespace League\CLImate\TerminalObject;

abstract class Repeatable extends BaseTerminalObject
{
    /**
     * How many times the element should be repeated
     *
     * @var integer
     */
    protected $count;

    public function __construct($count = 1)
    {
        $this->count = (int) round(max((int) $count, 1));
    }

}
