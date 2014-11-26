<?php

namespace League\CLImate\TerminalObject;

class Indent extends BaseTerminalObject
{
    /**
     * How far the content should be indented
     *
     * @var integer $level
     */

    protected $level = 1;

    /**
     * The content to output
     *
     * @var string|array $content
     */

    protected $content = null;

    public function __construct($content, $level = 1)
    {
        $this->content = $content;
        $this->level   = $level;
    }

    /**
     * Return the indented content
     *
     * @return string
     */

    public function result()
    {
        if (!is_array($this->content)) {
            $this->content = [$this->content];
        }

        $tabs = (new Tab($this->level))->result();

        $lines = array_map(function($line) use ($tabs) {
            return $tabs . $line;
        }, $this->content);

        return $lines;
    }
}
