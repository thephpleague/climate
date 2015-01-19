<?php

namespace League\CLImate\TerminalObject\Dynamic;

use League\CLImate\TerminalObject\Helper\Art;
use League\CLImate\TerminalObject\Helper\StringLength;
use League\CLImate\TerminalObject\Helper\Sleeper;

class Animation extends DynamicTerminalObject
{
    use Art, StringLength;

    /**
     * @var \League\CLImate\TerminalObject\Helper\Sleeper $sleeper
     */
    protected $sleeper;

    public function __construct($art, Sleeper $sleeper = null)
    {
        // Add the default art directory
        $this->addDir(__DIR__ . '/../../ASCII');

        $this->setSleeper($sleeper);

        $this->art = $art;
    }

    /**
     * Run a basic animation
     */
    public function run()
    {
        $files     = $this->artDir($this->art);
        $animation = [];

        foreach ($files as $file) {
            $animation[] = $this->parse($file);
        }

        $this->animate($animation);
    }

    /**
     * Set the speed of the animation based on a percentage
     * (50% slower, 200% faster, etc)
     *
     * @param int|float $percentage
     *
     * @return \League\CLImate\TerminalObject\Dynamic\Animation
     */
    public function speed($percentage)
    {
        $this->sleeper->speed($percentage);

        return $this;
    }

    /**
     * Scroll the art
     *
     * @param string $direction up|down|right|left
     */
    public function scroll($direction = 'right')
    {
        $mapping = [
            'left'   => 'right',
            'right'  => 'left',
            'top'    => 'bottom',
            'bottom' => 'top',
            'up'     => 'bottom',
            'down'   => 'top',
        ];

        if (!array_key_exists($direction, $mapping)) {
            return false;
        }

        $keyframes   = $this->enterKeyframes($mapping[$direction]);
        $keyframes   = array_merge($keyframes, $this->exitKeyframes($mapping[$mapping[$direction]]));
        $keyframes   = array_unique($keyframes, SORT_REGULAR);
        $keyframes[] = reset($keyframes);

        $this->animate($keyframes);
    }

    /**
     * Animate the art exiting the screen
     *
     * @param string $direction top|bottom|right|left
     */
    public function exitTo($direction)
    {
        $this->animate($this->exitKeyframes($direction));
    }

    /**
     * Animate the art entering the screen
     *
     * @param string $direction top|bottom|right|left
     */
    public function enterFrom($direction)
    {
        $this->animate($this->enterKeyframes($direction));
    }

    /**
     * @param \League\CLImate\TerminalObject\Helper\Sleeper $sleeper
     */
    protected function setSleeper($sleeper = null)
    {
        $this->sleeper = $sleeper ?: new Sleeper();
    }

    /**
     * Get the line parser for the direction
     *
     * @param string $direction
     * @return string
     */
    protected function getLineMethod($direction)
    {
        return 'current' . ucwords(strtolower($direction)) . 'Line';
    }

    /**
     * Adjust the array of lines if necessary
     *
     * @param array $lines
     * @param string $direction
     *
     * @return array
     */
    protected function adjustLines(array $lines, $direction)
    {
        $adjust_method = 'adjust' . ucwords(strtolower($direction))  . 'Lines';

        if (method_exists($this, $adjust_method)) {
            return $this->$adjust_method($lines);
        }

        return $lines;
    }

    /**
     * Pad the array of lines for "right" animation
     *
     * @param array $lines
     * @return array
     */
    protected function adjustRightLines(array $lines)
    {
        return $this->padArray($lines, $this->util->width());
    }

    /**
     * Pad the array of lines for "left" animation
     *
     * @param array $lines
     * @return array
     */
    protected function adjustLeftLines(array $lines)
    {
        return $this->padArray($lines, $this->maxStrLen($lines));
    }

    /**
     * Get the keyframes appropriate for the animation direction
     *
     * @param string $direction
     * @param array $lines
     * @param string $line_method
     *
     * @return array
     */
    protected function getDirectionKeyframes($direction, array $lines, $line_method)
    {
        $mapping = [
            'exitHorizontalKeyframes' => ['left', 'right'],
            'exitVerticalKeyFrames'   => ['top', 'bottom'],
        ];

        foreach ($mapping as $method => $directions) {
            if (in_array($direction, $directions)) {
                return $this->$method($lines, $line_method);
            }
        }

        // Fail gracefully, simply return an array
        return [];
    }

    /**
     * Get the enter keyframes for the desired direction
     *
     * @param string $direction
     *
     * @return array
     */
    protected function enterKeyframes($direction)
    {
        return array_reverse($this->exitKeyframes($direction));
    }

    /**
     * Get the exit keyframes for the desired direction
     *
     * @param string $direction
     *
     * @return array
     */
    protected function exitKeyframes($direction)
    {
        $lines       = $this->parse($this->artFile($this->art));
        $lines       = $this->adjustLines($lines, $direction);
        $line_method = $this->getLineMethod($direction);

        $direction_keyframes = $this->getDirectionKeyframes($direction, $lines, $line_method);

        $keyframes   = array_fill(0, 4, $lines);
        $keyframes   = array_merge($keyframes, $direction_keyframes);
        $keyframes[] = array_fill(0, count($lines), '');

        return $keyframes;
    }

    /**
     * Create horizontal exit animation keyframes for the art
     *
     * @param array $lines
     * @param string $line_method
     *
     * @return array
     */
    protected function exitHorizontalKeyframes(array $lines, $line_method)
    {
        $keyframes = [];
        $length    = strlen($lines[0]);

        for ($i = $length; $i > 0; $i--) {
            $current_frame = [];
            foreach ($lines as $line) {
                $current_frame[] = $this->$line_method($line, $i, $length);
            }

            $keyframes[] = $current_frame;
        }

        return $keyframes;
    }

    /**
     * Create vertical exit animation keyframes for the art
     *
     * @param array $lines
     * @param string $line_method
     *
     * @return array
     */
    protected function exitVerticalKeyFrames(array $lines, $line_method)
    {
        $keyframes  = [];
        $line_count = count($lines);

        for ($i = $line_count - 1; $i >= 0; $i--) {
            $keyframes[] = $this->$line_method($lines, $line_count, $i);
        }

        return $keyframes;
    }

    /**
     * Get the current line as it is exiting left
     *
     * @param string $line
     * @param int $frame_number
     * @param int $length
     *
     * @return string
     */
    protected function currentLeftLine($line, $frame_number, $length)
    {
        return substr($line, -$frame_number);
    }


    /**
     * Get the current line as it is exiting right
     *
     * @param string $line
     * @param int $frame_number
     * @param int $length
     *
     * @return string
     */
    protected function currentRightLine($line, $frame_number, $length)
    {
        return str_repeat(' ', $length - $frame_number) . substr($line, 0, $frame_number);
    }

    /**
     * Slice off X number of lines from the bottom and fill the rest with empty strings
     *
     * @param array $lines
     * @param integer $total_lines
     * @param integer $current
     *
     * @return array
     */
    protected function currentTopLine($lines, $total_lines, $current)
    {
        $keyframe = array_slice($lines, -$current, $current);

        return array_merge($keyframe, array_fill(0, $total_lines - $current, ''));
    }

    /**
     * Slice off X number of lines from the top and fill the rest with empty strings
     *
     * @param array $lines
     * @param integer $total_lines
     * @param integer $current
     *
     * @return array
     */
    protected function currentBottomLine($lines, $total_lines, $current)
    {
        $keyframe = array_fill(0, $total_lines - $current, '');

        return array_merge($keyframe, array_slice($lines, 0, $current));
    }

    /**
     * Animate the given keyframes
     *
     * @param array $keyframes Array of arrays
     */
    protected function animate(array $keyframes)
    {
        $count = 0;

        foreach ($keyframes as $lines) {
            $this->writeKeyFrame($lines, $count);
            $this->sleeper->sleep();
            $count = count($lines);
        }
    }

    /**
     * Write the current keyframe to the terminal, line by line
     *
     * @param array $lines
     * @param integer $count
     */
    protected function writeKeyFrame(array $lines, $count)
    {
        foreach ($lines as $key => $line) {
            $content = $this->getLineFormatted($line, $key, $count);
            $this->output->write($this->parser->apply($content));
        }
    }

    /**
     * Format the line to re-write previous lines, if necessary
     *
     * @param string $line
     * @param integer $key
     * @param integer $last_frame_count
     *
     * @return string
     */
    protected function getLineFormatted($line, $key, $last_frame_count)
    {
        // If this is the first thing we're writing, just return the line
        if ($last_frame_count == 0) {
            return $line;
        }

        $content = '';

        // If this is the first line of the frame,
        // move the cursor up the total number of previous lines from the previous frame
        if ($key == 0) {
            $content .= $this->util->cursor->up($last_frame_count);
        }

        $content .= $this->util->cursor->startOfCurrentLine();
        $content .= $this->util->cursor->deleteCurrentLine();
        $content .= $line;

        return $content;
    }

}
