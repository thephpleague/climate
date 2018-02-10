<?php

namespace League\CLImate\Util\Writer;

use League\CLImate\Tests\TestBase;

function fopen($resource, $mode)
{
    return TestBase::$functions->fopen($resource, $mode);
}

function flock($resource, $state)
{
    return TestBase::$functions->flock($resource, $state);
}

function gzopen($resource, $mode)
{
    return TestBase::$functions->gzopen($resource, $mode);
}
