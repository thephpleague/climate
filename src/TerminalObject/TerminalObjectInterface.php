<?php

namespace CLImate\TerminalObject;

interface TerminalObjectInterface
{
    public function result();

    public function settings();

    public function importSetting( $setting );

}
