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
        $this->addDir(__DIR__ . '/../../ASCII/animations');

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
     * Animate the art exiting to the top of the screen
     */
    public function exitToTop()
    {
        $this->fromStatic('leave', 'top');
    }

    /**
     * Animate the art entering from the top of the screen
     */
    public function enterFromTop()
    {
        $this->fromStatic('enter', 'top');
    }

    /**
     * Animate the art exiting to the bottom of the screen
     */
    public function exitToBottom()
    {
        $this->fromStatic('leave', 'bottom');
    }

    /**
     * Animate the art entering from the bottom of the screen
     */
    public function enterFromBottom()
    {
        $this->fromStatic('enter', 'bottom');
    }

    public function exitToLeft()
    {
        $this->animate($this->exitHorizontalKeyframes('left'));
    }

    public function enterFromLeft()
    {
        $this->animate(array_reverse($this->exitHorizontalKeyframes('left')));
    }

    public function exitToRight()
    {
        $this->animate($this->exitToRightKeyframes());
    }

    public function enterFromRight()
    {
        $this->animate(array_reverse($this->exitToRightKeyframes()));
    }

    /**
     * @param \League\CLImate\TerminalObject\Helper\Sleeper $sleeper
     */
    protected function setSleeper($sleeper)
    {
        $this->sleeper = $sleeper ?: new Sleeper();
    }

    protected function exitToRightKeyframes()
    {
        return $this->exitHorizontalKeyframes('right', $this->util->width());
    }

    protected function exitHorizontalKeyframes($direction, $width = null)
    {
        $lines  = $this->parse($this->artFile($this->art));
        $length = $width ?: $this->maxStrLen($lines);
        $lines  = $this->padArray($lines, $length);

        $line_method = 'exit' . ucwords($direction) . 'Line';

        $keyframes = array_fill(0, 3, $lines);

        for ($i = $length; $i > 0; $i--) {
            $current_frame = [];
            foreach ($lines as $line) {
                $current_frame[] = $this->$line_method($line, $i, $length);
            }

            $keyframes[] = $current_frame;
        }

        $keyframes[] = array_fill(0, count($lines), '');

        return $keyframes;
    }

    protected function exitLeftLine($line, $i, $length)
    {
        return substr($line, -$i);
    }

    protected function exitRightLine($line, $i, $length)
    {
        return str_repeat(' ', $length - $i) . substr($line, 0, $i);
    }

    /**
     * Create an animation from static art
     *
     * @param string $type Accepts enter|leave
     * @param string $direction Accepts top|bottom
     */
    protected function fromStatic($type, $direction)
    {
        $lines       = $this->parse($this->artFile($this->art));
        $line_method = $this->getLineMethod($direction);

        $keyframes   = $this->$type($lines, count($lines), $line_method);

        $this->animate($keyframes);
    }

    /**
     * Create the entrance animation
     *
     * @param array $lines
     * @param integer $line_count
     * @param string $line_method
     *
     * @return array
     */
    protected function enter($lines, $line_count, $line_method)
    {
        $keyframes = [array_fill(0, $line_count, '')];

        for ($i = 1; $i < $line_count; $i++) {
            $keyframes[] = $this->$line_method($lines, $line_count, $i);
        }

        $keyframes[] = $lines;

        return $keyframes;
    }

    /**
     * Create the exit animation
     *
     * @param array $lines
     * @param integer $line_count
     * @param string $line_method
     *
     * @return array
     */
    protected function leave($lines, $line_count, $line_method)
    {
        $keyframes = array_fill(0, 4, $lines);

        for ($i = $line_count - 1; $i >= 0; $i--) {
            $keyframes[] = $this->$line_method($lines, $line_count, $i);
        }

        $keyframes[] = array_fill(0, $line_count, '');

        return $keyframes;
    }

    /**
     * Retrieve the corresponding line helper method
     *
     * @param string $direction Accepts top|bottom
     *
     * @return string
     */
    protected function getLineMethod($direction)
    {
        $map = [
            'bottom' => 'top',
            'top'    => 'bottom',
        ];

        return 'get' . ucwords($map[$direction]) . 'Lines';
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
    protected function getBottomLines($lines, $total_lines, $current)
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
    protected function getTopLines($lines, $total_lines, $current)
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
