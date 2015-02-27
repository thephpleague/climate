<?php

require_once 'TestBase.php';

class CLImateLoggerTest extends TestBase
{
    /**
     * @var \League\CLImate\CLImateLogger
     */
    public $logger = null;

    public function setUp()
    {
        parent::setUp();
        $this->logger = new \League\CLImate\CLImateLogger();
        $this->logger->setOutput($this->output);
        $this->logger->setUtil($this->util);
    }

    public function testEmergency()
    {
        return $this->logger->emergency("Testing emergency");
    }

    public function testAlert()
    {
        return $this->logger->alert("Testing alert");
    }

    public function testCritical()
    {
        return $this->logger->critical("Testing critical");
    }

    public function testError()
    {
        return $this->logger->error("Testing error");
    }

    public function testWarning()
    {
        return $this->logger->warning("Testing warning");
    }

    public function testNotice()
    {
        return $this->logger->notice("Testing notice");
    }

    public function testInfo()
    {
        return $this->logger->info("Testing info");
    }

    public function testDebug()
    {
        return $this->logger->debug("Testing debug");
    }

    public function testLog()
    {
        return $this->logger->log("critical", "Testing log");
    }
}