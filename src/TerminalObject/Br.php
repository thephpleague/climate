<?php

namespace League\CLImate\TerminalObject;

class Br extends BaseTerminalObject
{
    protected $count;

    public function __construct($count = 1)
    {
        $this->count = round(max((int) $count, 1));
    }

    /**
     * Return an empty string
     *
     * @return string
     */

    public function result()
    {
        return array_fill(0, $this->count, '');
    }
}
