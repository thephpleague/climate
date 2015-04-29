<?php

namespace League\CLImate\TerminalObject\Dynamic;

class Radio extends Checkboxes
{
    /**
     * Toggle the currently selected option, uncheck all of the others
     */
    protected function toggleCurrent()
    {
        list($option, $option_key) = $this->getCurrent();

        $option->setChecked(!$option->isChecked());

        foreach ($this->options as $key => $option) {
            if ($key == $option_key) {
                continue;
            }

            $option->setChecked(false);
        }
    }

    /**
     * Get the checked option
     *
     * @return string|bool|int
     */
    protected function getChecked()
    {
        if ($checked = reset(array_filter($this->options, [$this, 'isChecked']))) {
            return $checked->getValue();
        }

        return null;
    }
}
