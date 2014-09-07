<?php

namespace CLImate\TerminalObject\Dynamic;

use CLImate\Settings\SettingsImporter;
use CLImate\Decorator\ParserImporter;

/**
 * The dynamic terminal object doesn't adhere to the basic terminal object
 * contract, which is why it gets its own base class
 */

abstract class BaseDynamicTerminalObject
{
    use SettingsImporter;
    use ParserImporter;
}
