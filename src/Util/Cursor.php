<?php

namespace League\CLImate\Util;

class Cursor
{
    /**
     * Move the cursor up in the terminal x number of lines.
     *
     * @param int $lines
     *
     * @return string
     */
    public function up($lines = 1)
    {
        return "\e[{$lines}A";
    }

    /**
     * Move the cursor down in the terminal x number of lines.
     *
     * @param int $lines
     *
     * @return string
     */
    public function down($lines = 1)
    {
        return "\e[{$lines}B";
    }

    /**
     * Move the cursor right in the terminal x number of columns.
     *
     * @param int $cols
     *
     * @return string
     */
    public function right($columns = 1)
    {
        return "\e[{$columns}C";
    }

    /**
     * Move the cursor left in the terminal x number of columns.
     *
     * @param int $cols
     *
     * @return string
     */
    public function left($cols = 1)
    {
        return "\e[{$cols}D";
    }

    /**
     * Move cursor to the beginning of the current line.
     *
     * @return string
     */
    public function startOfCurrentLine()
    {
        return "\r";
    }

    /**
     * Delete the current line to the end.
     *
     * @return string
     */
    public function deleteCurrentLine()
    {
        return "\e[K";
    }

    /**
     * Get the style for hiding the cursor
     *
     * @return string
     */
    public function hide()
    {
        return "\e[?25l";
    }

    /**
     * Get the style for returning the cursor to its default
     *
     * @return string
     */
    public function defaultStyle()
    {
        return "\e[?25h";
    }
}
