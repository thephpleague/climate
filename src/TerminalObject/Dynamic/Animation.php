<?php

namespace League\CLImate\TerminalObject\Dynamic;

use League\CLImate\TerminalObject\Dynamic\Animation\Keyframe;
use League\CLImate\TerminalObject\Helper\Art;
use League\CLImate\TerminalObject\Helper\Sleeper;

class Animation extends DynamicTerminalObject
{
    use Art;

    /**
     * @var \League\CLImate\TerminalObject\Helper\Sleeper $sleeper
     */
    protected $sleeper;

    /**
     * @var \League\CLImate\TerminalObject\Dynamic\Animation\Keyframe $keyframes
     */
    protected $keyframes;

    public function __construct($art, Sleeper $sleeper = null, Keyframe $keyframes = null)
    {
        // Add the default art directory
        $this->addDir(__DIR__ . \DIRECTORY_SEPARATOR . '..' . \DIRECTORY_SEPARATOR . '..' . \DIRECTORY_SEPARATOR . 'ASCII');

        $this->setSleeper($sleeper);
        $this->setKeyFrames($keyframes);

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
     * @param string $direction
     * @return bool
     */
    public function scroll($direction = 'right')
    {
        $this->setupKeyframes();

        $mapping = $this->getScrollDirectionMapping();

        if (!array_key_exists($direction, $mapping)) {
            return false;
        }

        $lines       = $this->getLines();
        $enter_from  = $mapping[$direction];
        $exit_to     = $mapping[$enter_from];

        $this->animate($this->keyframes->scroll($lines, $enter_from, $exit_to));
    }

    /**
     * Animate the art exiting the screen
     *
     * @param string $direction top|bottom|right|left
     */
    public function exitTo($direction)
    {
        $this->setupKeyframes();

        $this->animate($this->keyframes->exitTo($this->getLines(), $direction));
    }

    /**
     * Animate the art entering the screen
     *
     * @param string $direction top|bottom|right|left
     */
    public function enterFrom($direction)
    {
        $this->setupKeyframes();

        $this->animate($this->keyframes->enterFrom($this->getLines(), $direction));
    }

    protected function getScrollDirectionMapping()
    {
        return [
            'left'   => 'right',
            'right'  => 'left',
            'top'    => 'bottom',
            'bottom' => 'top',
            'up'     => 'bottom',
            'down'   => 'top',
        ];
    }

    protected function getLines()
    {
        return $this->parse($this->artFile($this->art));
    }

    /**
     * @param \League\CLImate\TerminalObject\Helper\Sleeper $sleeper
     */
    protected function setSleeper($sleeper = null)
    {
        $this->sleeper = $sleeper ?: new Sleeper();
    }

    /**
     * @param League\CLImate\TerminalObject\Dynamic\Animation\Keyframe $keyframes
     */
    protected function setKeyFrames($keyframes)
    {
        $this->keyframes = $keyframes ?: new Keyframe;
    }

    /**
     * Set up the necessary properties on the Keyframe class
     */
    protected function setupKeyframes()
    {
        $this->keyframes->parser($this->parser);
        $this->keyframes->util($this->util);
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
