<?php

namespace League\CLImate\TerminalObject\Dynamic;

use League\CLImate\TerminalObject\Helper\Art;

class Animation extends DynamicTerminalObject
{
    use Art;

    protected $speed = 1;

    public function __construct($art)
    {
        // Add the default art directory
        $this->addDir(__DIR__ . '/../../ASCII');
        $this->addDir(__DIR__ . '/../../ASCII/animations');

        $this->art = $art;
    }

    public function speed($percentage)
    {
        if (is_numeric($percentage)) {
            $this->speed = $percentage / 100;
        }

        return $this;
    }

    public function exitToTop()
    {
        $this->leave('top');
    }

    public function exitToBottom()
    {
        $this->leave('bottom');
    }

    public function enterFromTop()
    {
        $this->enter('top');
    }

    public function enterFromBottom()
    {
        $this->enter('bottom');
    }

    /**
     * Run a basic animation
     */
    public function run()
    {
        $files = $this->artDir($this->art);
        $files = array_reverse($files);

        $animation = [];

        foreach ($files as $file) {
            $animation[] = $this->parse($file);
        }

        $this->animate($animation);
    }

    protected function enter($origin)
    {
        $file        = $this->artFile($this->art);
        $lines       = $this->parse($file);
        $line_count  = count($lines);
        $line_method = $this->getLineMethod($origin);

        $keyframes   = [array_fill(0, $line_count, '')];

        for ($i = 1; $i < $line_count; $i++) {
            $keyframes[] = $this->$line_method($lines, $line_count, $i);
        }

        $keyframes[] = $lines;

        $this->animate($keyframes);
    }

    protected function leave($destination)
    {
        $file        = $this->artFile($this->art);
        $lines       = $this->parse($file);
        $line_count  = count($lines);
        $line_method = $this->getLineMethod($destination);

        $keyframes = [];

        $keyframes[] = $lines;
        $keyframes[] = $lines;
        $keyframes[] = $lines;
        $keyframes[] = $lines;

        for ($i = $line_count - 1; $i >= 0; $i--) {
            $keyframes[] = $this->$line_method($lines, $line_count, $i);
        }

        $keyframes[] = array_fill(0, $line_count, '');


        $this->animate($keyframes);
    }

    protected function getLineMethod($direction)
    {
        $map = [
            'bottom' => 'top',
            'top'    => 'bottom',
        ];

        return 'get' . ucwords($map[$direction]) . 'Lines';
    }

    protected function getBottomLines($lines, $total_lines, $current)
    {
        $keyframe = array_slice($lines, -$current, $current);

        return array_merge($keyframe, array_fill(0, $total_lines - $current, ''));
    }

    protected function getTopLines($lines, $total_lines, $current)
    {
        $keyframe = array_fill(0, $total_lines - $current, '');

        return array_merge($keyframe, array_slice($lines, 0, $current));
    }

    /**
     * Animate the given keyframes
     * @param array $keyframes Array of arrays
     */
    protected function animate(array $keyframes)
    {
        $count = 0;

        foreach ($keyframes as $lines) {
            $this->writeKeyFrame($lines, $count);
            $this->sleep();
            $count = count($lines);
        }
    }

    protected function writeKeyFrame(array $lines, $count)
    {
        foreach ($lines as $key => $line) {
            $content = $this->getLineFormatted($line, $key, $count);
            $this->output->write($this->parser->apply($content));
        }
    }

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

    protected function sleep()
    {
        usleep(50000 * $this->speed);
    }

}
