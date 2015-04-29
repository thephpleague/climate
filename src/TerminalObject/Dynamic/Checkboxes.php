<?php

namespace League\CLImate\TerminalObject\Dynamic;

use League\CLImate\Util\Reader\ReaderInterface;
use League\CLImate\Util\Reader\Stdin;

class Checkboxes extends InputAbstract
{
    /**
     * The options to choose from
     *
     * @var array $options
     */
    protected $options = [];

    public function __construct($prompt, array $options, ReaderInterface $reader = null)
    {
        $this->prompt  = $prompt;
        $this->options = $this->buildOptions($options);
        $this->reader  = $reader ?: new Stdin();
    }

    /**
     * Do it! Prompt the user for information!
     *
     * @return string
     */
    public function prompt()
    {
        $this->output->write($this->parser->apply($this->promptFormatted()));

        $this->writeOptions();

        return $this->getChecked();
    }

    /**
     * Retrieve the checked options
     *
     * @return array
     */
    protected function getChecked()
    {
        $checked = array_filter($this->options, [$this, 'isChecked']);

        return array_map([$this, 'getValue'], $checked);
    }

    /**
     * Determine whether the option is checked
     *
     * @param Checkbox $option
     *
     * @return bool
     */
    protected function isChecked($option)
    {
        return $option->isChecked();
    }

    /**
     * Retrieve the option's value
     *
     * @param Checkbox $option
     *
     * @return mixed
     */
    protected function getValue($option)
    {
        return $option->getValue();
    }

    /**
     * Build out the array of options
     *
     * @param array $options
     *
     * @return array
     */
    protected function buildOptions(array $options)
    {
        $result = [];

        foreach ($options as $key => $option) {
            $result[] = new Checkbox($option, $key);
        }

        $result[0]->setFirst()->setCurrent();
        $result[count($result) - 1]->setLast();

        return $result;
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
     * Output the options and listen for any keystrokes
     */
    protected function writeOptions()
    {
        $this->updateOptionsView();

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
            switch ($char) {
                case "\e":
                    $this->handleAnsi();
                break;

                case "\n":
                    $this->output->sameLine()->write($this->util->cursor->defaultStyle());
                    $this->output->sameLine()->write("\e[0m");
                break 2; // Break the while loop as well

                case ' ':
                    $this->toggleCurrent();
                break;
            }

            $this->moveCursorToTop();
            $this->updateOptionsView();
        }
    }

    /**
     * Move the cursor to the top of the option list
     */
    protected function moveCursorToTop()
    {
        $this->output->sameLine()->write($this->util->cursor->up(count($this->options) - 1));
        $this->output->sameLine()->write($this->util->cursor->startOfCurrentLine());
    }

    /**
     * Handle any ANSI characters
     */
    protected function handleAnsi()
    {
        switch ($this->reader->char(2)) {
            // Up arrow
            case '[A':
                $this->setCurrent('previous');
            break;

            // Down arrow
            case '[B':
                $this->setCurrent('next');
            break;
        }
    }

    /**
     * Toggle the current option's checked status
     */
    protected function toggleCurrent()
    {
        list($option, $key) = $this->getCurrent();

        $option->setChecked(!$option->isChecked());
    }

    /**
     * Get the currently selected option
     *
     * @return array
     */
    protected function getCurrent()
    {
        foreach ($this->options as $key => $option) {
            if ($option->isCurrent()) {
                return [$option, $key];
            }
        }
    }

    /**
     * Set the newly selected option based on the direction
     *
     * @param string $direction 'previous' or 'next'
     */
    protected function setCurrent($direction)
    {
        list($option, $key) = $this->getCurrent();

        $option->setCurrent(false);

        $new_key = $this->getCurrentKey($direction, $option, $key);

        $this->options[$new_key]->setCurrent();
    }

    /**
     * Retrieve the correct current key
     *
     * @param string $direction 'previous' or 'next'
     * @param Checkbox $option
     * @param int $key
     *
     * @return int
     */
    protected function getCurrentKey($direction, $option, $key)
    {
        $method = 'get' . ucwords($direction). 'Key';

        return $this->{$method}($option, $key);
    }

    /**
     * @param Checkbox $option
     * @param int $key
     *
     * @return int
     */
    protected function getPreviousKey($option, $key)
    {
        if ($option->isFirst()) {
            return count($this->options) - 1;
        }

        return --$key;
    }

    /**
     * @param Checkbox $option
     * @param int $key
     *
     * @return int
     */
    protected function getNextKey($option, $key)
    {
        if ($option->isLast()) {
            return 0;
        }

        return ++$key;
    }

    /**
     * Re-write the options based on the current objects
     */
    protected function updateOptionsView()
    {
        foreach ($this->options as $option) {
            $this->writeOption($option);
        }
    }

    /**
     * @param Checkbox $option
     */
    protected function writeOption($option)
    {
        $option->util($this->util);

        $formatted = $this->parser->apply((string) $option);

        if ($option->isLast()) {
            $this->output->sameLine()->write($formatted);
            return;
        }

        $this->output->write($formatted);
    }

}
