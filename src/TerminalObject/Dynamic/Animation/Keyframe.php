<?php

namespace League\CLImate\TerminalObject\Dynamic\Animation;

use League\CLImate\Decorator\Parser\ParserImporter;
use League\CLImate\TerminalObject\Helper\StringLength;
use League\CLImate\Util\UtilImporter;

class Keyframe
{
    use StringLength, ParserImporter, UtilImporter;

    /**
     * Get the enter keyframes for the desired direction
     *
     * @param array $lines
     * @param string $direction
     *
     * @return array
     */
    public function enterFrom($lines, $direction)
    {
        return array_reverse($this->exitTo($lines, $direction));
    }

    /**
     * Get the exit keyframes for the desired direction
     *
     * @param array $lines
     * @param string $direction
     *
     * @return array
     */
    public function exitTo($lines, $direction)
    {
        $lines       = $this->adjustLines($lines, $direction);
        $line_method = $this->getLineMethod($direction);

        $direction_keyframes = $this->getDirectionFrames($direction, $lines, $line_method);

        $keyframes   = array_fill(0, 4, $lines);
        $keyframes   = array_merge($keyframes, $direction_keyframes);
        $keyframes[] = array_fill(0, count($lines), '');

        return $keyframes;
    }

    /**
     * Get scroll keyframes
     *
     * @param array $lines
     * @param string $enter_from
     * @param string $exit_to
     *
     * @return array
     */
    public function scroll($lines, $enter_from, $exit_to)
    {
        $keyframes   = $this->enterFrom($lines, $enter_from);
        $keyframes   = array_merge($keyframes, $this->exitTo($lines, $exit_to));
        $keyframes   = array_unique($keyframes, SORT_REGULAR);
        $keyframes[] = reset($keyframes);

        return $keyframes;
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
    protected function getDirectionFrames($direction, array $lines, $line_method)
    {
        $mapping = [
            'exitHorizontalFrames' => ['left', 'right'],
            'exitVerticalFrames'   => ['top', 'bottom'],
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
     * Create horizontal exit animation keyframes for the art
     *
     * @param array $lines
     * @param string $line_method
     *
     * @return array
     */
    protected function exitHorizontalFrames(array $lines, $line_method)
    {
        $keyframes = [];
        $length    = strlen($lines[0]);

        for ($i = $length; $i > 0; $i--) {
            $keyframes[] = $this->getHorizontalKeyframe($lines, $i, $line_method, $length);
        }

        return $keyframes;
    }

    /**
     * Get the keyframe for a horizontal animation
     *
     * @param array $lines
     * @param int $frame_number
     * @param string $line_method
     * @param int $length
     *
     * @return array
     */
    protected function getHorizontalKeyframe(array $lines, $frame_number, $line_method, $length)
    {
        $keyframe = [];

        foreach ($lines as $line) {
            $keyframe[] = $this->$line_method($line, $frame_number, $length);
        }

        return $keyframe;
    }

    /**
     * Create vertical exit animation keyframes for the art
     *
     * @param array $lines
     * @param string $line_method
     *
     * @return array
     */
    protected function exitVerticalFrames(array $lines, $line_method)
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
     *
     * @return string
     */
    protected function currentLeftLine($line, $frame_number)
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
}
