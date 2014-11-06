<?php

namespace League\CLImate\TerminalObject;

interface TerminalObjectInterface
{
    public function result();

    public function settings();

    /**
     * @return void
     */
    public function importSetting( $setting );

    /**
     * @return boolean
     */
    public function sameLine();
}
