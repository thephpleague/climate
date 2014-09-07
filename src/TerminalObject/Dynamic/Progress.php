<?php

namespace CLImate\TerminalObject\Dynamic;

class Progress extends BaseDynamicTerminalObject
{
    protected $total           = 0;

    protected $full_bar_length = 100;

    public function __construct($total = null)
    {
        if ($total) {
            $this->total($total);
        }
    }

    public function result()
    {
    }

    public function output()
    {
        return false;
    }

    public function total($total)
    {
        echo "\n";

        $this->total = $total;

        return $this;
    }

    public function current($current, $label = null)
    {
        if ($this->total == 0) {
            // Avoid dividing by 0
            throw new \Exception('The progress total must be greater than zero.');
        }

        if ($current > $this->total) {
            throw new \Exception('The current is greater than the total.');
        }

        $percentage = $current / $this->total;

        $bar_length = round($this->full_bar_length * $percentage);

        $percentage *= 100;

        $percentage = round($percentage);

        $bar_str    = str_repeat('=', $bar_length);
        $bar_str    .= '> ';
        $bar_str    .= $percentage;
        $bar_str    .= '% ';
        $bar_str    .= $label;

        $bar_str    = trim($bar_str);

        $this->cli->out("\e[1A\r\e[K{$bar_str}");
    }
}
