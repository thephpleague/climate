<?php

namespace League\CLImate\Tests;

use League\CLImate\CLImate;
use League\CLImate\Decorator\Style;
use League\CLImate\Logger;
use Mockery;
use Mockery\Mock;
use PHPUnit\Framework\TestCase;
use Psr\Log\InvalidArgumentException;
use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;

class LoggerTest extends TestCase
{
    /**
     * @var Logger $logger The instance we are testing.
     */
    private $logger;

    /**
     * @var CLImate|Mock $cli A climate instance to test with.
     */
    private $cli;


    public function setUp(): void
    {
        $this->cli = Mockery::mock(CLImate::class);

        $style = Mockery::mock(Style::class);
        $style->shouldReceive("get")->andReturn(true);
        $this->cli->style = $style;

        $this->logger = new Logger(LogLevel::DEBUG, $this->cli);
    }


    public function tearDown(): void
    {
        Mockery::close();
    }


    public function testConstructor1()
    {
        $logger = new Logger();
        $this->assertInstanceOf(LoggerInterface::class, $logger);
        $this->assertInstanceOf(Logger::class, $logger);
    }
    public function testConstructor2()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Unknown log level: ");
        new Logger("");
    }
    public function testConstructor3()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Unknown log level: 15");
        new Logger(15);
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testEmergency()
    {
        $this->cli->shouldReceive("emergency")->once()->with("Testing emergency");
        $this->logger->emergency("Testing emergency");
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testAlert()
    {
        $this->cli->shouldReceive("alert")->once()->with("Testing alert");
        $this->logger->alert("Testing alert");
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testCritical()
    {
        $this->cli->shouldReceive("critical")->once()->with("Testing critical");
        $this->logger->critical("Testing critical");
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testError()
    {
        $this->cli->shouldReceive("error")->once()->with("Testing error");
        $this->logger->error("Testing error");
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testWarning()
    {
        $this->cli->shouldReceive("warning")->once()->with("Testing warning");
        $this->logger->warning("Testing warning");
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testNotice()
    {
        $this->cli->shouldReceive("notice")->once()->with("Testing notice");
        $this->logger->notice("Testing notice");
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testInfo()
    {
        $this->cli->shouldReceive("info")->once()->with("Testing info");
        $this->logger->info("Testing info");
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testDebug()
    {
        $this->cli->shouldReceive("debug")->once()->with("Testing debug");
        $this->logger->debug("Testing debug");
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testLog()
    {
        $this->cli->shouldReceive("critical")->once()->with("Testing log");
        $this->logger->log(LogLevel::CRITICAL, "Testing log");
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testLevelEmergency()
    {
        $this->cli->shouldReceive(LogLevel::EMERGENCY)->once()->with("Testing log");
        $this->logger->withLogLevel(LogLevel::EMERGENCY)->emergency("Testing log");
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testLevelAlert()
    {
        $this->cli->shouldReceive("alert")->never();
        $this->logger->withLogLevel(LogLevel::EMERGENCY)->alert("Testing log");
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testLevelNotice()
    {
        $this->cli->shouldReceive(LogLevel::NOTICE)->once()->with("Notice");
        $this->logger->withLogLevel(LogLevel::NOTICE)->notice("Notice");
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testLevelDebug()
    {
        $this->cli->shouldReceive(LogLevel::DEBUG)->once()->with("Debug");
        $this->logger->withLogLevel(LogLevel::DEBUG)->debug("Debug");
    }


    public function testWithInvalidLogLevel1()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Unknown log level: INVALID");
        $this->logger->withLogLevel("INVALID");
    }
    public function testWithInvalidLogLevel2()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Unknown log level: 0");
        $this->logger->withLogLevel(0);
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testContext()
    {
        $this->cli->shouldReceive("info")->once()->with("With context");

        $this->cli->shouldReceive("tab")->with(1)->once()->andReturn($this->cli);
        $this->cli->shouldReceive("info")->once()->andReturn($this->cli);
        $this->cli->shouldReceive("inline")->once()->with("context: ");
        $this->cli->shouldReceive("info")->once()->with("CONTEXT");

        $this->logger->info("With context", [
            "context" => "CONTEXT",
        ]);
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testEmptyContext()
    {
        $this->cli->shouldReceive("info")->once()->with("No context");
        $this->logger->info("No context", []);
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testPlaceholders()
    {
        $this->cli->shouldReceive("info")->once()->with("I am Spartacus!");
        $this->logger->info("I am {username}!", [
            "username" => "Spartacus",
        ]);
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testPlaceholdersAndContext()
    {
        $this->cli->shouldReceive("info")->once()->with("I am Spartacus!");

        $this->cli->shouldReceive("tab")->with(1)->once()->andReturn($this->cli);
        $this->cli->shouldReceive("info")->once()->andReturn($this->cli);
        $this->cli->shouldReceive("inline")->once()->with("date: ");
        $this->cli->shouldReceive("info")->once()->with("2015-03-01");

        $this->logger->info("I am {username}!", [
            "username" => "Spartacus",
            "date" => "2015-03-01",
        ]);
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testRecursiveContext()
    {
        $this->cli->shouldReceive("info")->once()->with("INFO");

        $this->cli->shouldReceive("tab")->with(1)->once()->andReturn($this->cli);
        $this->cli->shouldReceive("info")->once()->andReturn($this->cli);
        $this->cli->shouldReceive("inline")->once()->with("data: ");
        $this->cli->shouldReceive("info")->once()->with("[");

        $this->cli->shouldReceive("tab")->with(2)->once()->andReturn($this->cli);
        $this->cli->shouldReceive("info")->once()->andReturn($this->cli);
        $this->cli->shouldReceive("inline")->once()->with("field1: ");
        $this->cli->shouldReceive("info")->once()->with("One");

        $this->cli->shouldReceive("tab")->with(2)->once()->andReturn($this->cli);
        $this->cli->shouldReceive("info")->once()->andReturn($this->cli);
        $this->cli->shouldReceive("inline")->once()->with("field2: ");
        $this->cli->shouldReceive("info")->once()->with("Two");

        $this->cli->shouldReceive("tab")->with(2)->once()->andReturn($this->cli);
        $this->cli->shouldReceive("info")->once()->andReturn($this->cli);
        $this->cli->shouldReceive("inline")->once()->with("extra: ");
        $this->cli->shouldReceive("info")->once()->with("[");

        $this->cli->shouldReceive("tab")->with(3)->once()->andReturn($this->cli);
        $this->cli->shouldReceive("info")->once()->andReturn($this->cli);
        $this->cli->shouldReceive("inline")->once()->with("0: ");
        $this->cli->shouldReceive("info")->once()->with("Three");

        $this->cli->shouldReceive("tab")->with(3)->once()->andReturn($this->cli);
        $this->cli->shouldReceive("info")->once()->andReturn($this->cli);
        $this->cli->shouldReceive("inline")->once()->with("1: ");
        $this->cli->shouldReceive("info")->once()->with("Four");

        $this->cli->shouldReceive("tab")->with(2)->once()->andReturn($this->cli);
        $this->cli->shouldReceive("info")->once()->with("]");

        $this->cli->shouldReceive("tab")->with(1)->once()->andReturn($this->cli);
        $this->cli->shouldReceive("info")->once()->with("]");

        $this->logger->info("INFO", [
            "data" => [
                "field1" => "One",
                "field2" => "Two",
                "extra" => ["Three", "Four"],
            ],
        ]);
    }
}
