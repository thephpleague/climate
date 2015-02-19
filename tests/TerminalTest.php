<?php

class StdioTest extends PHPUnit_Framework_TestCase
{
    public function testInstanciation()
    {
        $terminal = new League\CLImate\Terminal();
        $this->assertInstanceOf('League\CLImate\CLImate', $terminal->stdErr);
        $this->assertInstanceOf('League\CLImate\CLImate', $terminal->stdOut);
    }
}
