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
        $this->addDir(__DIR__ . '/../../ASCII/animations');

        $this->art = $art;
    }

    public function speed($multiplier)
    {
        if (is_numeric($multiplier)) {
            $this->speed = $multiplier;
        }

        return $this;
    }

    public function enterFromTop()
    {
        $files = $this->path($this->art);
        var_dump($files);
    }

    /**
	 * Return the art
	 *
	 * @return array
	 */

    public function run()
    {
        $files = $this->artDir($this->art);

        $files = array_reverse($files);

        // $files = [
        //     ['[]'],
        //     ['[H]'],
        //     ['[He]'],
        //     ['[Hel]'],
        //     ['[Hell]'],
        //     ['[Hello]'],
        //     ['[Hello ]'],
        //     ['[Hello W]'],
        //     ['[Hello Wo]'],
        //     ['[Hello Wor]'],
        //     ['[Hello Worl]'],
        //     ['[Hello World]'],
        //     ['[Hello World /'],
        //     ['[Hello World  -'],
        //     ['[Hello World   ['],
        //     ['[Hello World    \\'],
        //     ['[Hello World     -'],
        //     ['[Hello World      ]'],
        //     ['[Hello World       ]'],
        //     ['[Hello World      ]'],
        //     ['[Hello World     ]'],
        //     ['[Hello World    ]'],
        //     ['[Hello World   ]'],
        //     ['[Hello World  ]'],
        //     ['[Hello World ]'],
        //     ['[Hello World]'],
        //     ['[Hello Worl]'],
        //     ['[Hello Wor]'],
        //     ['[Hello Wo]'],
        //     ['[Hello W]'],
        //     ['[Hello ]'],
        //     ['[Hello]'],
        //     ['[Hell]'],
        //     ['[Hel]'],
        //     ['[He]'],
        //     ['[H]'],
        //     ['[]'],
        // ];

        $animation = [];

        foreach ($files as $file) {
            $animation[] = $this->parse($file);
        }

        $this->animate($animation);
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

    protected function getLineFormatted($line, $key, $count)
    {
        // If this is the first thing we're writing, just return the line
        if ($count == 0) {
            return $line;
        }

        $content = '';

        // If this is the first line of the next frame,
        // move the cursor up the total number of previous lines
        if ($key == 0) {
            $content .= $this->util->cursor->up($count);
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
