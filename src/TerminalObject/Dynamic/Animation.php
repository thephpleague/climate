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
    public function exitTo($direction)
    {
        $this->animate($this->getDirectionKeyframes($direction));
    }

    public function enterFrom($direction)
    {
        $this->animate(array_reverse($this->getDirectionKeyframes($direction)));
    }

    protected function getDirectionKeyframes($direction)
    {
        $direction_method = strtolower($direction) . 'Keyframes';

        if (method_exists($this, $direction_method)) {
            return $this->$direction_method();
        }

        $mapping = [
            'exitHorizontalKeyframes' => ['left', 'right'],
            'exitVerticalKeyFrames'   => ['top', 'bottom'],
        ];

        foreach ($mapping as $method => $directions) {
            if (in_array($direction, $directions)) {
                return $this->$method($direction);
            }
        }

        // Fail gracefully, simply return an array
        return [];
    }

    /**
     * @param \League\CLImate\TerminalObject\Helper\Sleeper $sleeper
     */
    protected function setSleeper($sleeper)
    {
        $this->sleeper = $sleeper ?: new Sleeper();
    }

    protected function rightKeyframes()
    {
        return $this->exitHorizontalKeyframes('right', $this->util->width());
    }

    protected function getLineMethod($direction)
    {
        return 'exit' . ucwords(strtolower($direction)) . 'Line';
    }

    protected function exitHorizontalKeyframes($direction, $width = null)
    {
        $lines       = $this->parse($this->artFile($this->art));
        $length      = $width ?: $this->maxStrLen($lines);
        $lines       = $this->padArray($lines, $length);
        $line_method = $this->getLineMethod($direction);

        $keyframes   = array_fill(0, 4, $lines);

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

    protected function exitVerticalKeyFrames($direction)
    {
        $lines       = $this->parse($this->artFile($this->art));
        $line_count  = count($lines);
        $line_method = $this->getLineMethod($direction);

        $keyframes   = array_fill(0, 4, $lines);

        for ($i = $line_count - 1; $i >= 0; $i--) {
            $keyframes[] = $this->$line_method($lines, $line_count, $i);
        }

        $keyframes[] = array_fill(0, $line_count, '');

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
     * Slice off X number of lines from the bottom and fill the rest with empty strings
     *
     * @param array $lines
     * @param integer $total_lines
     * @param integer $current
     *
     * @return array
     */
    protected function exitTopLine($lines, $total_lines, $current)
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
    protected function exitBottomLine($lines, $total_lines, $current)
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
