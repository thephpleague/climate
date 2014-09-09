<?php

namespace CLImate\TerminalObject\Dynamic;

use CLImate\Decorator\ParserImporter;
use CLImate\Settings\SettingsImporter;

/**
 * The dynamic terminal object doesn't adhere to the basic terminal object
 * contract, which is why it gets its own base class
 */

abstract class BaseDynamicTerminalObject
{
    use SettingsImporter;
    use ParserImporter;
}
