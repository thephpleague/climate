<?php

namespace League\CLImate\TerminalObject;

class Out extends BaseTerminalObject
{
    protected $content;

    public function __construct($content)
    {
        $this->content = $content;
    }

    /**
     * Return an empty string
     *
     * @return string
     */

    public function result()
    {
        return $this->content;
    }
}
