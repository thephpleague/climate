<?php

require_once 'TestBase.php';

class CLImateLoggerTest extends TestBase
{
    /**
     * @var \League\CLImate\CLImateLogger
     */
    public $cli = null;

    public function setUp()
    {
        parent::setUp();
        $this->cli = new League\CLImate\CLImateLogger();
        $this->cli->setOutput($this->output);
        $this->cli->setUtil($this->util);
    }

    public function testEmergency()
    {
        $this->shouldWrite("\e[mThis would go out to the console.\e[0m");
        $this->cli->emergency("Testing emergency");
    }

    public function testAlert()
    {
        $this->shouldWrite("\e[mThis would go out to the console.\e[0m");
        $this->cli->alert("Testing alert");
    }

    public function testCritical()
    {
        $this->shouldWrite("\e[mThis would go out to the console.\e[0m");
        $this->cli->critical("Testing critical");
    }

    public function testError()
    {
        $this->shouldWrite("\e[mThis would go out to the console.\e[0m");
        $this->cli->error("Testing error");
    }

    public function testWarning()
    {
        $this->shouldWrite("\e[mThis would go out to the console.\e[0m");
        $this->cli->warning("Testing warning");
    }

    public function testNotice()
    {
        $this->shouldWrite("\e[mThis would go out to the console.\e[0m");
        $this->cli->notice("Testing notice");
    }

    public function testInfo()
    {
        $this->shouldWrite("\e[mThis would go out to the console.\e[0m");
        $this->cli->info("Testing info");
    }

    public function testDebug()
    {
        $this->shouldWrite("\e[mThis would go out to the console.\e[0m");
        $this->cli->debug("Testing debug");
    }

    public function testLog()
    {
        $this->shouldWrite("\e[mThis would go out to the console.\e[0m");
        $this->cli->log("critical", "Testing log");
    }
}