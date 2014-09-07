<?php

namespace CLImate\TerminalObject;

use CLImate\Decorator\Parser;

abstract class BaseTerminalObject implements TerminalObjectInterface
{

    protected $style;

    /**
     * Empty constructor as placeholder
     * in case extending classes use it
     */

    public function __construct()
    {

    }

    public function style(Parser $style)
    {
        $this->style = $style;
    }

    /**
     * Dictates an any settings that a terminal
     * object may need access to
     *
     * @return array
     */

    public function settings()
    {
        return [];
    }

    /**
     * Import the setting into the terminal object
     *
     * @param CLImate\Settings $setting
     */

    public function importSetting($setting)
    {
        $short_name = basename(str_replace('\\', '/', get_class($setting)));

        $method = 'importSetting' . $short_name;

        if (method_exists($this, $method)) {
            $this->$method($setting);
        }

    }

}
