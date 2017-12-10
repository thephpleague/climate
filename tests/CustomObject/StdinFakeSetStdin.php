<?php
namespace League\CLImate\Tests\CustomObject;

class StdinFakeSetStdin extends StdinFake
{
    /**
     * Generate error exception
     * @throws \Exception
     */
    protected function setStdIn()
    {
        throw new \Exception("error exception");
    }
}