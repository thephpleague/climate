<?php

namespace League\CLImate\TerminalObject\Dynamic;

use League\CLImate\Output;

class Progress extends BaseDynamicTerminalObject
{
    /**
     * The total number of items involved
     *
     * @var integer $total
     */

    protected $total       = 0;

    /**
     * The string length of the bar when at 100%
     *
     * @var integer $bar_str_len
     */

    protected $bar_str_len = 100;

    /**
     * If they pass in a total, set the total
     *
     * @param integer $total
     */

    public function __construct($total = null)
    {
        if ($total) $this->total($total);
    }

    /**
     * Set the total property
     *
     * @param  integer                                 $total
     * @return Progress
     */

    public function total($total)
    {
        // Drop down a line, we are about to
        // re-write this line for the progress bar
        echo "\n";

        $this->total = $total;

        return $this;
    }

    /**
     * Determines the current percentage we are at and re-writes the progress bar
     *
     * @param integer $current
     * @param mixed   $label
     */

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

        $bar_length = round($this->bar_str_len * $percentage);

        $percentage *= 100;

        $percentage = round($percentage);

        // Basically:
        // =============>             50% label
        $bar_str = str_repeat('=', $bar_length);
        $bar_str .= '> ';
        $bar_str .= str_repeat(' ', $this->bar_str_len - $bar_length);
        $bar_str .= $percentage;
        $bar_str .= '% ';

        if ($percentage < 100) {
            $bar_str .= $label;
        }

        $bar_str = trim($bar_str);

        echo new Output("\e[1A\r\e[K{$bar_str}", $this->parser);
    }
}
