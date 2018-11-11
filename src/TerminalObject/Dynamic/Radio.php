<?php

namespace League\CLImate\TerminalObject\Dynamic;

class Radio extends Checkboxes
{
    /**
     * Build out the checkboxes
     *
     * @param array $options
     *
     * @return Checkbox\RadioGroup
     */
    protected function buildCheckboxes(array $options)
    {
        return new Checkbox\RadioGroup($options);
    }

    /**
     * Take the appropriate action based on the input character,
     * returns whether to stop listening or not
     *
     * @param string $char
     *
     * @return bool
     */
    protected function handleCharacter($char)
    {
        switch ($char) {
            case ' ':
            case "\n":
                $this->checkboxes->toggleCurrent();
                $this->output->sameLine()->write($this->util->cursor->defaultStyle());
                $this->output->sameLine()->write("\e[0m");
                return true; // Break the while loop as well

            case "\e":
                $this->handleAnsi();
                break;
        }

        return false;
    }

    /**
     * Format the prompt string
     *
     * @return string
     */
    protected function promptFormatted()
    {
        return $this->prompt . ' (press <Enter> to select)';
    }
}
