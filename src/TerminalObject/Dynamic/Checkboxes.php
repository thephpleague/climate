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
        $this->options = $this->formatOptions($options);
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

        $this->writeCheckboxes();

        return $this->getChecked();
    }

    protected function getChecked()
    {
        $checked = array_filter($this->options, [$this, 'isChecked']);

        return array_map([$this, 'getValue'], $checked);
    }

    protected function isChecked($option)
    {
        return $option->isChecked();
    }

    protected function getValue($option)
    {
        return $option->getValue();
    }

    protected function formatOptions(array $options)
    {
        $formatted = [];

        foreach ($options as $key => $option) {
            $formatted[] = new Checkbox($option, $key);
        }

        $formatted[0]->setFirst()->setCurrent();
        $formatted[count($formatted) - 1]->setLast();

        return $formatted;
    }

    protected function promptFormatted()
    {
        return $this->prompt . ' (use <space> to select)';
    }

    protected function writeCheckboxes()
    {
        $this->updateOptionsView();

        $this->util->system->exec('stty -icanon');
        $this->output->sameLine()->write($this->util->cursor->hide());

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

    protected function moveCursorToTop()
    {
        $this->output->sameLine()->write($this->util->cursor->up(count($this->options) - 1));
        $this->output->sameLine()->write($this->util->cursor->startOfCurrentLine());
    }

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

    protected function toggleCurrent()
    {
        list($option, $key) = $this->getCurrent();

        $option->setChecked(!$option->isChecked());
    }

    protected function getCurrent()
    {
        foreach ($this->options as $key => $option) {
            if ($option->isCurrent()) {
                return [$option, $key];
            }
        }
    }

    protected function setCurrent($direction)
    {
        list($option, $key) = $this->getCurrent();

        $option->setCurrent(false);

        $new_key = $this->getCurrentKey($direction, $option, $key);

        $this->options[$new_key]->setCurrent();
    }

    protected function getCurrentKey($direction, $option, $key)
    {
        $method = 'get' . ucwords($direction). 'Key';

        return $this->{$method}($option, $key);
    }

    protected function getPreviousKey($option, $key)
    {
        if ($option->isFirst()) {
            return count($this->options) - 1;
        }

        return --$key;
    }

    protected function getNextKey($option, $key)
    {
        if ($option->isLast()) {
            return 0;
        }

        return ++$key;
    }

    protected function updateOptionsView()
    {
        foreach ($this->options as $option) {
            $this->writeOption($option);
        }
    }

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
