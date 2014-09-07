<?php

namespace CLImate\TerminalObject;

use CLImate\Settings\SettingsImporter;
use CLImate\Decorator\ParserImporter;

abstract class BaseTerminalObject implements TerminalObjectInterface
{
    use SettingsImporter;
    use ParserImporter;
}
