<?php

namespace League\CLImate\Util\Reader;

class Stdin extends Stream
{
    public function __construct()
    {
        parent::__construct("php://stdin");
    }
}
