<?php

namespace League\CLImate\Util\Reader;

use League\CLImate\Tests\TestBase;

function fopen($resource, $mode) {
    return TestBase::$functions->fopen($resource, $mode);
}

function fgets($resource, $length) {
    return TestBase::$functions->fgets($resource, $length);
}

function fread($resource, $length) {
    return TestBase::$functions->fread($resource, $length);
}

function stream_get_contents($resource) {
    return TestBase::$functions->stream_get_contents($resource);
}
