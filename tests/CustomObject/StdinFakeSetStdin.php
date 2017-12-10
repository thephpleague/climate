<?php
namespace League\CLImate\Tests\CustomObject;

class StdinFakeSetStdin extends StdinFake
{
    /**
     * Generate error exception
     * @throws \Error
     */
    protected function setStdIn()
    {
        throw new \Error("error exception");
    }
}