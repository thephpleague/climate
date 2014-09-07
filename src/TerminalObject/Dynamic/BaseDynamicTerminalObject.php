<?php

namespace CLImate\TerminalObject\Dynamic;

use CLImate\Settings\SettingsImporter;
use CLImate\Decorator\ParserImporter;

abstract class BaseDynamicTerminalObject
{
    use SettingsImporter;
    use ParserImporter;
}
