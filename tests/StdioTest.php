<?php

class StdioTest extends PHPUnit_Framework_TestCase
{
    public function testInstanciation()
    {
        $stdio = new League\CLImate\Stdio();
        $this->assertInstanceOf('League\CLImate\CLImate', $stdio->err());
        $this->assertInstanceOf('League\CLImate\CLImate', $stdio->out());
    }
}
