<?php
namespace League\CLImate\Tests\CustomObject;

use Error;

class StdinFakeSetStdin extends StdinFake
{
    /**
     * Generate error exception
     * @throws \Error
     */
    protected function setStdIn()
    {
        throw new Error("error exception");
    }
}