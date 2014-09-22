<?php

namespace League\CLImate\TerminalObject;

use League\CLImate\Decorator\ParserImporter;
use League\CLImate\Settings\SettingsImporter;

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

    /**
     * Get the parser for the current object
     *
     * @return \League\CLImate\Decorator\Parser
     */

    public function getParser()
    {
        return $this->parser;
    }
}
