<?php

namespace League\CLImate\Tests;

use League\CLImate\CLImate;
use Mockery;

class TestBase extends \PHPUnit_Framework_TestCase
{
    public static $functions;

    /** @var League\CLImate\CLImate */
    public $cli;

    /** @var League\CLImate\Util\Output|Mockery\MockInterface */
    public $output;

    /** @var League\CLImate\Util\Reader\Stdin|Mockery\MockInterface */
    public $reader;

    /** @var League\CLImate\Util\UtilFactory */
    public $util;

    protected $record_it = false;

    public function setUp()
    {
        self::$functions = Mockery::mock();

        $system = Mockery::mock('League\CLImate\Util\System\Linux');
        $system->shouldReceive('hasAnsiSupport')->andReturn(true);
        $system->shouldReceive('width')->andReturn(80);

        $this->util   = new \League\CLImate\Util\UtilFactory($system);
        $this->output = Mockery::mock('League\CLImate\Util\Output');
        $this->reader = Mockery::mock('League\CLImate\Util\Reader\Stdin');

        $this->cli = new CLImate();
        $this->cli->setOutput($this->output);
        $this->cli->setUtil($this->util);

        if (method_exists($this, 'internalSetup')) {
            $this->internalSetup();
        }
    }

    public function tearDown()
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
        if ($this->record_it) {
            file_put_contents('test-log', $content, FILE_APPEND);
        }

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

    /** @test */
    public function it_does_nothing()
    {
        // nada
    }
}
