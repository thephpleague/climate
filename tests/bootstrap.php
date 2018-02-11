<?php

require __DIR__ . "/../vendor/autoload.php";

set_error_handler(static function ($errno, $errstr, $errfile, $errline): bool {
    if (!(error_reporting() & $errno)) {
        return false;
    }
    throw new \ErrorException($errstr, 0, $errno, $errfile, $errline);
}, \E_ALL);
