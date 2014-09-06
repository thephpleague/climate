<?php

namespace CLImate\TerminalObject\Settings;

class Art implements SettingsInterface
{
    public $dirs = [];

    public function add()
    {
        $this->dirs = array_merge($this->dirs, func_get_args());
        $this->dirs = array_filter($this->dirs);
        $this->dirs = array_values($this->dirs);
    }

}
