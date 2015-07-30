<?php

namespace League\CLImate\TerminalObject\Helper;

use League\CLImate\Tests\TestBase;

function usleep($microseconds)
{
    return TestBase::$functions->usleep($microseconds);
}
