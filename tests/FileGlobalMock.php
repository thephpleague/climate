<?php

namespace League\CLImate\Util\Writer;

require_once('TestBase.php');

use TestBase;

function fopen($resource, $mode) {
    return TestBase::$functions->fopen($resource, $mode);
}
