<?php

namespace League\CLImate\TerminalObject\Dynamic\Checkbox;

use League\CLImate\Decorator\Parser\ParserImporter;
use League\CLImate\Util\OutputImporter;
use League\CLImate\Util\UtilImporter;

class CheckboxGroup
{
    use OutputImporter;
    use ParserImporter;
    use UtilImporter;

    protected $checkboxes = [];

    protected $count;

    /**
     * The index of the first option currently drawn
     *
     * @var int
     */
    protected $offset = 0;

    /**
     * The number of options drawn the last time the group was written
     *
     * @var int
     */
    protected $visibleCount = 0;

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
        $visible = $this->getVisibleCheckboxes();

        $this->visibleCount = count($visible);

        foreach ($visible as $line => $checkbox) {
            $this->writeCheckbox($checkbox, $line === $this->visibleCount - 1);
        }
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
        list($option) = $this->getCurrent();

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
     * Get the number of options drawn the last time the group was written
     *
     * @return int
     */
    public function visibleCount()
    {
        return $this->visibleCount;
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
        $method = 'get' . ucwords($direction) . 'Key';

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
     * Get the options that fit in the terminal, scrolled so the current one is visible
     *
     * @return Checkbox[]
     */
    protected function getVisibleCheckboxes()
    {
        // Leave a line for the prompt, the cursor can't move above the top of the terminal
        $height = max(1, $this->util->height() - 1);

        if ($this->count <= $height) {
            return $this->checkboxes;
        }

        list(, $key) = $this->getCurrent();

        if ($key < $this->offset) {
            $this->offset = $key;
        } elseif ($key >= $this->offset + $height) {
            $this->offset = $key - $height + 1;
        }

        $this->offset = min($this->offset, $this->count - $height);

        return array_slice($this->checkboxes, $this->offset, $height);
    }

    /**
     * @param Checkbox $checkbox
     * @param bool $isLastLine
     */
    protected function writeCheckbox($checkbox, $isLastLine)
    {
        $checkbox->util($this->util);
        $checkbox->parser($this->parser);

        $line = (string) $checkbox;

        // The last option already ends with this, the last line drawn needs it too
        if ($isLastLine && !$checkbox->isLast()) {
            $line .= $this->util->cursor->left(10) . '<hidden>';
        }

        $parsed = $this->parser->apply($line);

        if ($isLastLine) {
            $this->output->sameLine()->write($parsed);
            return;
        }

        $this->output->write($parsed);
    }
}
