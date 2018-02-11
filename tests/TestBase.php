<?php

namespace League\CLImate\Tests;

use League\CLImate\CLImate;
use League\CLImate\Util\Output;
use League\CLImate\Util\Reader\Stdin;
use League\CLImate\Util\System\Linux;
use League\CLImate\Util\UtilFactory;
use Mockery;
use PHPUnit\Framework\TestCase;

abstract class TestBase extends TestCase
{
    public static $functions;

    /** @var CLImate */
    public $cli;

    /** @var Output|Mockery\MockInterface */
    public $output;

    /** @var Stdin|Mockery\MockInterface */
    public $reader;

    /** @var UtilFactory */
    public $util;


    public function setUp(): void
    {
        self::$functions = Mockery::mock();

        $system = Mockery::mock(Linux::class);
        $system->shouldReceive('hasAnsiSupport')->andReturn(true);
        $system->shouldReceive('width')->andReturn(80);

        $this->util   = new UtilFactory($system);
        $this->output = Mockery::mock(Output::class);
        $this->reader = Mockery::mock(Stdin::class);

        $this->cli = new CLImate();
        $this->cli->setOutput($this->output);
        $this->cli->setUtil($this->util);
    }

    public function tearDown(): void
    {
        Mockery::close();
    }

    /**
     * Helper for writer mock
     *
     * @param string  $content
     * @param integer $count
     */
    protected function shouldWrite($content, $count = 1)
    {
        return $this->output->shouldReceive('write')->times($count)->with($content);
    }

    /**
     * Helper for reader mock
     *
     * @param string $response
     */
    protected function shouldReadAndReturn($response)
    {
        $this->reader->shouldReceive('line')->once()->andReturn($response);
    }

    /**
     * Helper for reader mock
     *
     * @param string $response
     */
    protected function shouldReadCharAndReturn($response, $char_count = 1)
    {
        $this->reader->shouldReceive('char')->with($char_count)->once()->andReturn($response);
    }

    /**
     * Helper for reader mock
     *
     * @param string $response
     */
    protected function shouldReadMultipleLinesAndReturn($response)
    {
        $this->reader->shouldReceive('multiLine')->once()->andReturn($response);
    }

    /**
     * Helper for same line output mock
     */
    protected function shouldReceiveSameLine()
    {
        $this->output->shouldReceive('sameLine')->andReturn($this->output);
    }

    protected function shouldHavePersisted($times = 1)
    {
        $this->shouldStartPersisting($times);
        $this->shouldStopPersisting($times);
    }

    protected function shouldStartPersisting($times = 1)
    {
        $this->output->shouldReceive('persist')->withNoArgs()->times($times)->andReturn($this->output);
    }

    protected function shouldStopPersisting($times = 1)
    {
        $this->output->shouldReceive('persist')->with(false)->times($times)->andReturn($this->output);
    }
}
