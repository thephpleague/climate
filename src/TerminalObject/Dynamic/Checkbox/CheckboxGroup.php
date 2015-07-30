<?php

namespace League\CLImate\TerminalObject\Dynamic\Checkbox;

use League\CLImate\Decorator\Parser\ParserImporter;
use League\CLImate\Util\OutputImporter;
use League\CLImate\Util\UtilImporter;

class CheckboxGroup
{
    use OutputImporter, ParserImporter, UtilImporter;

    protected $checkboxes = [];

    protected $count;

    public function __construct(array $options)
    {
        foreach ($options as $key => $option) {
            $this->checkboxes[] = new Checkbox($option, $key);
        }

        $this->count = count($this->checkboxes);

        $this->checkboxes[0]->setFirst()->setCurrent();
        $this->checkboxes[$this->count - 1]->setLast();
    }

    public function write()
    {
        array_map([$this, 'writeCheckbox'], $this->checkboxes);
    }

    /**
     * Retrieve the checked option values
     *
     * @return array
     */
    public function getCheckedValues()
    {
        return array_values(array_map([$this, 'getValue'], $this->getChecked()));
    }

    /**
     * Set the newly selected option based on the direction
     *
     * @param string $direction 'previous' or 'next'
     */
    public function setCurrent($direction)
    {
        list($option, $key) = $this->getCurrent();

        $option->setCurrent(false);

        $new_key = $this->getCurrentKey($direction, $option, $key);

        $this->checkboxes[$new_key]->setCurrent();
    }

    /**
     * Toggle the current option's checked status
     */
    public function toggleCurrent()
    {
        list($option, $key) = $this->getCurrent();

        $option->setChecked(!$option->isChecked());
    }

    /**
     * Get the number of checkboxes
     *
     * @return int
     */
    public function count()
    {
        return $this->count;
    }

    /**
     * Retrieve the checked options
     *
     * @return array
     */
    protected function getChecked()
    {
        return array_filter($this->checkboxes, [$this, 'isChecked']);
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
     * Get the currently selected option
     *
     * @return array
     */
    protected function getCurrent()
    {
        foreach ($this->checkboxes as $key => $option) {
            if ($option->isCurrent()) {
                return [$option, $key];
            }
        }
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
            return count($this->checkboxes) - 1;
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
     * @param Checkbox $checkbox
     */
    protected function writeCheckbox($checkbox)
    {
        $checkbox->util($this->util);
        $checkbox->parser($this->parser);

        $parsed = $this->parser->apply((string) $checkbox);

        if ($checkbox->isLast()) {
            $this->output->sameLine()->write($parsed);
            return;
        }

        $this->output->write($parsed);
    }
}
