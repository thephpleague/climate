<?php

namespace League\CLImate\TerminalObject\Dynamic;

use League\CLImate\Decorator\Parser\Parser;
use League\CLImate\Util\UtilFactory;

interface DynamicTerminalObjectInterface
{
    public function settings();

    /**
     * @param $setting
     * @return void
     */
    public function importSetting($setting);

    /**
     * @param \League\CLImate\Decorator\Parser\Parser $parser
     */
    public function parser(Parser $parser);

    /**
     * @param UtilFactory $util
     */
    public function util(UtilFactory $util);
}
