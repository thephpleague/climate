<?php
namespace League\CLImate\Tests\CustomObject;

use League\CLImate\Util\Reader\Stdin;

class StdinFake extends Stdin
{
    public function callSetSdinFake()
    {
        $this->setStdIn();
    }
    public function callGetStdIn()
    {
        $this->getStdIn();
    }
    public function changeStdin($value)
    {
        $this->stdIn = $value;
    }
}