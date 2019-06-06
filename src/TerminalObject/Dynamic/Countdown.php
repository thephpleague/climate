<?php

namespace League\CLImate\TerminalObject\Dynamic;

use function sleep;

final class Countdown extends DynamicTerminalObject
{
    /** @var string */
    private $label = "";

    /** @var int */
    private $from = 5;


    /**
     * @param string $label
     */
    public function __construct(string $label = "Starting in... ")
    {
        $this->label = $label;
    }


    /**
     * @param int $from
     *
     * @return self
     */
    public function from(int $from): self
    {
        $this->from = $from;
        return $this;
    }


    /**
     * @return void
     */
    public function run(): void
    {
        $firstLine = true;
        $i = $this->from;
        while (true) {

            $content = "";

            if ($firstLine) {
                $firstLine = false;
            } else {
                $content .= $this->util->cursor->up(1);
                $content .= $this->util->cursor->startOfCurrentLine();
                $content .= $this->util->cursor->deleteCurrentLine();
            }

            $content .= $this->label;
            if ($i > 0) {
                $content .= $i;
            }

            $this->output->write($this->parser->apply($content));
            if ($i < 1) {
                break;
            }

            sleep(1);
            --$i;
        }
    }
}
