<?php

class LoggerTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var \League\CLImate\CLImate $cli
     */
    protected $cli;

    /**
     * @var \League\CLImate\Logger $logger
     */
    protected $logger;

    public function setUp()
    {
        $this->cli = Mockery::mock('League\CLImate\CLImate');

        $style = Mockery::mock('League\CLImate\Decorator\Style');
        $style->shouldReceive("get")->andReturn(true);
        $this->cli->style = $style;

        $this->logger = new League\CLImate\Logger($this->cli);
    }

    public function tearDown()
    {
        Mockery::close();
    }

    /** @test */
    public function it_can_log_emergencies()
    {
        $this->cli->shouldReceive("emergency")->once()->with("Testing emergency");
        $this->logger->emergency("Testing emergency");
    }

    /** @test */
    public function it_can_log_alert()
    {
        $this->cli->shouldReceive("alert")->once()->with("Testing alert");
        $this->logger->alert("Testing alert");
    }

    /** @test */
    public function it_can_log_critically()
    {
        $this->cli->shouldReceive("critical")->once()->with("Testing critical");
        $this->logger->critical("Testing critical");
    }

    /** @test */
    public function it_can_log_errors()
    {
        $this->cli->shouldReceive("error")->once()->with("Testing error");
        $this->logger->error("Testing error");
    }

    /** @test */
    public function it_can_log_warnings()
    {
        $this->cli->shouldReceive("warning")->once()->with("Testing warning");
        $this->logger->warning("Testing warning");
    }

    /** @test */
    public function it_can_log_notices()
    {
        $this->cli->shouldReceive("notice")->once()->with("Testing notice");
        $this->logger->notice("Testing notice");
    }

    /** @test */
    public function it_can_log_info()
    {
        $this->cli->shouldReceive("info")->once()->with("Testing info");
        $this->logger->info("Testing info");
    }

    /** @test */
    public function it_can_log_debug()
    {
        $this->cli->shouldReceive("debug")->once()->with("Testing debug");
        $this->logger->debug("Testing debug");
    }

    /** @test */
    public function it_can_log_generically()
    {
        $this->cli->shouldReceive("critical")->once()->with("Testing log");
        $this->logger->log("critical", "Testing log");
    }

    /** @test */
    public function it_can_log_with_context()
    {
        $this->cli->shouldReceive("info")->once()->with("With context");
        $this->cli->shouldReceive("tab")->once()->andReturn($this->cli);
        $this->cli->shouldReceive("info")->once()->with("context: CONTEXT");
        $this->logger->info("With context", [
            "context"   =>  "CONTEXT",
        ]);
    }

    /** @test */
    public function it_can_log_with_empty_context()
    {
        $this->cli->shouldReceive("info")->once()->with("No context");
        $this->logger->info("No context", []);
    }

    /** @test */
    public function it_can_log_with_placeholders()
    {
        $this->cli->shouldReceive("info")->once()->with("I am Spartacus!");
        $this->logger->info("I am {username}!", [
            "username"  =>  "Spartacus",
        ]);
    }

    /** @test */
    public function it_can_log_with_placeholders_and_context()
    {
        $this->cli->shouldReceive("info")->once()->with("I am Spartacus!");
        $this->cli->shouldReceive("tab")->once()->andReturn($this->cli);
        $this->cli->shouldReceive("info")->once()->with("date: 2015-03-01");
        $this->logger->info("I am {username}!", [
            "username"  =>  "Spartacus",
            "date"      =>  "2015-03-01",
        ]);
    }
}
