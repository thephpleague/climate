<?php

namespace CLImate\TerminalObject;

use CLImate\Decorator\ParserImporter;
use CLImate\Settings\SettingsImporter;

abstract class BaseTerminalObject implements TerminalObjectInterface
{
    use SettingsImporter;
    use ParserImporter;
}
