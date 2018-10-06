<?php

namespace League\CLImate\TerminalObject\Dynamic;

use League\CLImate\Exceptions\UnexpectedValueException;

class Progress extends DynamicTerminalObject
{
    /**
     * The total number of items involved
     *
     * @var integer $total
     */
    protected $total = 0;

    /**
     * The current item that the progress bar represents
     *
     * @var integer $current
     */
    protected $current = 0;

    /**
     * The current percentage displayed
     *
     * @var string $current_percentage
     */
    protected $current_percentage = '';

    /**
     * The string length of the bar when at 100%
     *
     * @var integer $bar_str_len
     */
    protected $bar_str_len;

    /**
     * Flag indicating whether we are writing the bar for the first time
     *
     * @var boolean $first_line
     */
    protected $first_line = true;

    /**
     * Current status bar label
     *
     * @var string $label
     */
    protected $label;

    /**
     * Force a redraw every time
     *
     * @var boolean $force_redraw
     */
    protected $force_redraw = false;

    /**
     * If this progress bar ever displayed a label.
     *
     * @var boolean $has_label_line
     */
    protected $has_label_line = false;

    /**
     * If they pass in a total, set the total
     *
     * @param integer $total
     */
    public function __construct($total = null)
    {
        if ($total !== null) {
            $this->total($total);
        }
    }

    /**
     * Set the total property
     *
     * @param  integer $total
     *
     * @return Progress
     */
    public function total($total)
    {
        $this->total = $total;

        return $this;
    }

    /**
     * Determines the current percentage we are at and re-writes the progress bar
     *
     * @param integer $current
     * @param mixed   $label
     *
     * @return void
     * @throws UnexpectedValueException
     */
    public function current($current, $label = null)
    {
        if ($this->total == 0) {
            // Avoid dividing by 0
            throw new UnexpectedValueException('The progress total must be greater than zero.');
        }

        if ($current > $this->total) {
            throw new UnexpectedValueException('The current is greater than the total.');
        }

        $this->drawProgressBar($current, $label);

        $this->current = $current;
        $this->label   = $label;
    }

    /**
     * Increments the current position we are at and re-writes the progress bar
     *
     * @param integer $increment The number of items to increment by
     * @param string $label
     */
    public function advance($increment = 1, $label = null)
    {
        $this->current($this->current + $increment, $label);
    }

    /**
     * Force the progress bar to redraw every time regardless of whether it has changed or not
     *
     * @param boolean $force
     * @return Progress
     */
    public function forceRedraw($force = true)
    {
        $this->force_redraw = !!$force;

        return $this;
    }


    /**
     * Update a progress bar using an iterable.
     *
     * @param iterable $items Array or any other iterable object
     * @param callable $callback A handler to run on each item
     */
    public function each($items, callable $callback = null)
    {
        if ($items instanceof \Traversable) {
            $items = iterator_to_array($items);
        }

        $total = count($items);
        if (!$total) {
            return;
        }
        $this->total($total);

        foreach ($items as $key => $item) {
            if ($callback) {
                $label = $callback($item, $key);
            } else {
                $label = null;
            }

            $this->advance(1, $label);
        }
    }


    /**
     * Draw the progress bar, if necessary
     *
     * @param string $current
     * @param string $label
     */
    protected function drawProgressBar($current, $label)
    {
        $percentage = $this->percentageFormatted($current / $this->total);

        if ($this->shouldRedraw($percentage, $label)) {
            $progress_bar = $this->getProgressBar($current, $label);
            $this->output->write($this->parser->apply($progress_bar));
        }

        $this->current_percentage = $percentage;
    }

    /**
     * Build the progress bar str and return it
     *
     * @param integer $current
     * @param string $label
     *
     * @return string
     */
    protected function getProgressBar($current, $label)
    {
        if ($this->first_line) {
            // Drop down a line, we are about to
            // re-write this line for the progress bar
            $this->output->write('');
            $this->first_line = false;
        }

        // Move the cursor up and clear it to the end
        $line_count = $this->has_label_line ? 2 : 1;

        $progress_bar  = $this->util->cursor->up($line_count);
        $progress_bar .= $this->util->cursor->startOfCurrentLine();
        $progress_bar .= $this->util->cursor->deleteCurrentLine();
        $progress_bar .= $this->getProgressBarStr($current, $label);

        // If this line has a label then set that this progress bar has a label line
        if (strlen($label) > 0) {
            $this->has_label_line = true;
        }

        return $progress_bar;
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
    protected function getProgressBarStr($current, $label)
    {
        $percentage = $current / $this->total;
        $bar_length = round($this->getBarStrLen() * $percentage);

        $bar        = $this->getBar($bar_length);
        $number     = $this->percentageFormatted($percentage);

        if ($label) {
            $label = $this->labelFormatted($label);
        // If this line doesn't have a label, but we've had one before,
        // then ensure the label line is cleared
        } elseif ($this->has_label_line) {
            $label = $this->labelFormatted('');
        }

        return trim("{$bar} {$number}{$label}");
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
        $padding = str_repeat(' ', $this->getBarStrLen() - $length);

        return "{$bar}>{$padding}";
    }

    /**
     * Get the length of the bar string based on the width of the terminal window
     *
     * @return integer
     */
    protected function getBarStrLen()
    {
        if (!$this->bar_str_len) {
            // Subtract 10 because of the '> 100%' plus some padding, max 100
            $this->bar_str_len = min($this->util->width() - 10, 100);
        }

        return $this->bar_str_len;
    }

    /**
     * Format the percentage so it looks pretty
     *
     * @param integer $percentage
     * @return float
     */
    protected function percentageFormatted($percentage)
    {
        return round($percentage * 100) . '%';
    }

    /**
     * Format the label so it is positioned correctly
     *
     * @param string $label
     * @return string
     */
    protected function labelFormatted($label)
    {
        return "\n" . $this->util->cursor->startOfCurrentLine() . $this->util->cursor->deleteCurrentLine() . $label;
    }

    /**
     * Determine whether the progress bar has changed and we need to redrew
     *
     * @param string $percentage
     * @param string $label
     *
     * @return boolean
     */
    protected function shouldRedraw($percentage, $label)
    {
        return ($this->force_redraw || $percentage != $this->current_percentage || $label != $this->label);
    }
}
