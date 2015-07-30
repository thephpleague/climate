<?php

namespace League\CLImate\TerminalObject\Dynamic\Checkbox;

class RadioGroup extends CheckboxGroup
{
    /**
     * Toggle the currently selected option, uncheck all of the others
     */
    public function toggleCurrent()
    {
        list($checkbox, $checkbox_key) = $this->getCurrent();

        $checkbox->setChecked(!$checkbox->isChecked());

        foreach ($this->checkboxes as $key => $checkbox) {
            if ($key == $checkbox_key) {
                continue;
            }

            $checkbox->setChecked(false);
        }
    }

    /**
     * Get the checked option
     *
     * @return string|bool|int
     */
    public function getCheckedValues()
    {
        if ($checked = $this->getChecked()) {
            return reset($checked)->getValue();
        }

        return null;
    }
}
