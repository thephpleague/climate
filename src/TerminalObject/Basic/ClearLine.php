<?php

namespace League\CLImate\TerminalObject\Basic;

final class ClearLine extends Repeatable
{
    /**
     * Clear the lines.
     *
     * @return string
     */
    public function result()
    {
        $string = "";
        while ($this->count > 0) {
            $string .= $this->util->cursor->startOfCurrentLine();
            $string .= $this->util->cursor->deleteCurrentLine();
            --$this->count;

            $string .= $this->util->cursor->up();
        }

        $string .= $this->util->cursor->down();

        return $string;
    }


    /**
     * @inheritdoc
     */
    public function sameLine()
    {
        return true;
    }
}
