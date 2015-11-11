<?php

namespace League\CLImate\TerminalObject\Dynamic;

use League\CLImate\Util\Reader\ReaderInterface;
use League\CLImate\Util\Reader\Stdin;

class Checkboxes extends InputAbstract
{
    /**
     * The options to choose from
     *
     * @var Checkbox\CheckboxGroup $checkboxes
     */
    protected $checkboxes;

    public function __construct($prompt, array $options, ReaderInterface $reader = null)
    {
        $this->prompt  = $prompt;
        $this->reader  = $reader ?: new Stdin();

        $this->checkboxes = $this->buildCheckboxes($options);
    }

    /**
     * Do it! Prompt the user for information!
     *
     * @return string
     */
    public function prompt()
    {
        $this->output->write($this->parser->apply($this->promptFormatted()));

        $this->writeCheckboxes();

        $this->util->system->exec('stty sane');

        return $this->checkboxes->getCheckedValues();
    }

    /**
     * Build out the checkboxes
     *
     * @param array $options
     *
     * @return Checkbox\CheckboxGroup
     */
    protected function buildCheckboxes(array $options)
    {
        return new Checkbox\CheckboxGroup($options);
    }

    /**
     * Format the prompt string
     *
     * @return string
     */
    protected function promptFormatted()
    {
        return $this->prompt . ' (use <space> to select)';
    }

    /**
     * Output the checkboxes and listen for any keystrokes
     */
    protected function writeCheckboxes()
    {
        $this->updateCheckboxView();

        $this->util->system->exec('stty -icanon');
        $this->output->sameLine()->write($this->util->cursor->hide());

        $this->listenForInput();
    }

    /**
     * Listen for input and act on it
     */
    protected function listenForInput()
    {
        while ($char = $this->reader->char(1)) {
            if ($this->handleCharacter($char)) {
                break;
            }

            $this->moveCursorToTop();
            $this->updateCheckboxView();
        }
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
            case "\n":
                $this->output->sameLine()->write($this->util->cursor->defaultStyle());
                $this->output->sameLine()->write("\e[0m");
            return true; // Break the while loop as well

            case "\e":
                $this->handleAnsi();
            break;

            case ' ':
                $this->checkboxes->toggleCurrent();
            break;
        }

        return false;
    }

    /**
     * Move the cursor to the top of the option list
     */
    protected function moveCursorToTop()
    {
        $output = $this->util->cursor->up($this->checkboxes->count() - 1);
        $output .= $this->util->cursor->startOfCurrentLine();

        $this->output->sameLine()->write($output);
    }

    /**
     * Handle any ANSI characters
     */
    protected function handleAnsi()
    {
        switch ($this->reader->char(2)) {
            // Up arrow
            case '[A':
                $this->checkboxes->setCurrent('previous');
            break;

            // Down arrow
            case '[B':
                $this->checkboxes->setCurrent('next');
            break;
        }
    }

    /**
     * Re-write the checkboxes based on the current objects
     */
    protected function updateCheckboxView()
    {
        $this->checkboxes->util($this->util);
        $this->checkboxes->output($this->output);
        $this->checkboxes->parser($this->parser);

        $this->checkboxes->write();
    }
}
