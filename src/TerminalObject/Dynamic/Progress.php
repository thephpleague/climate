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

        // Move the cursor up one line and clear it to the end
        $progress_bar = "\e[1A\r\e[K";
        $progress_bar .= $this->getProgressBar($current, $label);

        echo new Output($progress_bar, $this->parser);
    }

    /**
     * Get the progress bar string, basically:
     * =============>             50% label
     *
     * @param integer $current
     * @param string $label
     *
     * @return string
     */

    protected function getProgressBar($current, $label)
    {
        $percentage = $current / $this->total;
        $bar_length = round($this->bar_str_len * $percentage);
        $label      = ($percentage < 1) ? $label: '';

        $bar        = $this->getBar($bar_length);
        $number     = $this->percentageFormatted($percentage);

        return trim("{$bar} {$number} {$label}");
    }

    /**
     * Get the string for the actual bar based on the current length
     *
     * @param integer $length
     *
     * @return string
     */

    protected function getBar($length)
    {
        $bar     = str_repeat('=', $length);
        $padding = str_repeat(' ', $this->bar_str_len - $length);

        return "{$bar}>{$padding}";
    }

    /**
     * Format the percentage so it looks pretty
     *
     * @param float|integer $percentage
     */

    protected function percentageFormatted($percentage)
    {
        return round($percentage * 100) . '%';
    }

}
