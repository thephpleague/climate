<?php

namespace League\CLImate\TerminalObject\Dynamic;

class Radio extends Checkboxes
{
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

    protected function getChecked()
    {
        if ($checked = reset(array_filter($this->options, [$this, 'isChecked']))) {
            return $checked->getValue();
        }

        return null;
    }
}
