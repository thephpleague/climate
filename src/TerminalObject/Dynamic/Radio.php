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
        # Ignore space, as we can't select multiple options
        if ($char === " ") {
            return false;
        }

        # Use enter to select the current option
        if ($char === "\n") {
            $this->checkboxes->toggleCurrent();
        }

        return parent::handleCharacter($char);
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
