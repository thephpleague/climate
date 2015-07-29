<?php

namespace League\CLImate\TerminalObject\Helper;

require_once('TestBase.php');

use TestBase;

function usleep($microseconds) {
    return TestBase::$functions->usleep($microseconds);
}
