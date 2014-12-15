<?php

namespace League\CLImate\TerminalObject;

class Out extends BaseTerminalObject
{
    /**
     * The content to output
     *
     * @var string $content
     */
    protected $content;

    public function __construct($content)
    {
        $this->content = $content;
    }

    /**
     * Return the content to output
     *
     * @return string
     */
    public function result()
    {
        return $this->content;
    }
}
