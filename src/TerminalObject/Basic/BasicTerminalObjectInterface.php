<?php

namespace League\CLImate\TerminalObject\Basic;

use League\CLImate\Decorator\Parser\Parser;
use League\CLImate\Util\UtilFactory;

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

    /**
     * @param \League\CLImate\Decorator\Parser\Parser $parser
     */
    public function parser(Parser $parser);

    /**
     * @param UtilFactory $util
     */
    public function util(UtilFactory $util);
}
