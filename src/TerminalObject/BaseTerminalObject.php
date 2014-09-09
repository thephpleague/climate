<?php

namespace CLImate\TerminalObject;

use CLImate\Decorator\ParserImporter;
use CLImate\Settings\SettingsImporter;

abstract class BaseTerminalObject implements TerminalObjectInterface
{
    use SettingsImporter;
    use ParserImporter;

    /**
     * Set the property if there is a valid value
     *
     * @param string $key
     * @param string $value
     */

    protected function set($key, $value)
    {
        if (strlen($value)) {
            $this->$key = $value;
        }
    }
}
