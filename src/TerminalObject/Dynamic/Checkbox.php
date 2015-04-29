<?php

namespace League\CLImate\TerminalObject\Dynamic;

use League\CLImate\Util\UtilImporter;

class Checkbox
{
    use UtilImporter;

    protected $value;

    protected $label;

    protected $checked = false;

    protected $current = false;

    protected $first = false;

    protected $last = false;

    public function __construct($label, $value)
    {
        $this->value = (!is_int($value)) ? $value : $label;
        $this->label = $label;
    }

    protected function checkbox($checked)
    {
        if ($checked) {
            return html_entity_decode("&#x25CF;");
        }

        return html_entity_decode("&#x25CB;");
    }

    protected function pointer()
    {
        return html_entity_decode("&#x276F;");
    }

    public function isCurrent()
    {
        return $this->current;
    }

    public function isChecked()
    {
        return $this->checked;
    }

    public function isFirst()
    {
        return $this->first;
    }

    public function isLast()
    {
        return $this->last;
    }

    public function setCurrent($current = true)
    {
        $this->current = $current;

        return $this;
    }

    public function setChecked($checked = true)
    {
        $this->checked = $checked;

        return $this;
    }

    public function setFirst()
    {
        $this->first = true;

        return $this;
    }

    public function setLast()
    {
        $this->last = true;

        return $this;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function __toString()
    {
        $line = [
            ($this->isCurrent()) ? $this->pointer() : ' ',
            $this->checkbox($this->isChecked()),
            $this->label,
        ];

        $line = implode(' ', $line);

        if ($this->first) {
            $line = "\e[0m" . $line;
        }

        $line .= str_repeat(' ', strlen($line));

        if ($this->last) {
            return $line . '<hidden>' . $this->util->cursor->left(10);
        }

        return $line;
    }

}
