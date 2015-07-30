<?php

namespace League\CLImate\TerminalObject\Basic;

interface BasicTerminalObjectInterface
{
    public function result();

    public function settings();

    /**
     * @param $setting
     * @return void
     */
    public function importSetting($setting);

    /**
     * @return boolean
     */
    public function sameLine();
}
