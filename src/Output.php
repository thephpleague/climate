<?php

namespace CLImate;

use CLImate\Decorator\Parser;

class Output
{
    protected $output;

    protected $style;

    public function __construct($output, Parser $style)
    {
        $this->output = $output;
        $this->style = $style;
    }

    public function __toString()
    {
        return $this->style->apply($this->output) . "\n";
    }
}
