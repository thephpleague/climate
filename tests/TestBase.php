<?php

class TestBase extends PHPUnit_Framework_TestCase
{
    /** @var League\CLImate\CLImate */
    public $cli;

    /** @var League\CLImate\Util\Output|Mockery\MockInterface */
    public $output;

    /** @var League\CLImate\Util\Reader\Stdin|Mockery\MockInterface */
    public $reader;

    /** @var League\CLImate\Util\UtilFactory */
    public $util;

    public function setUp()
    {
        $system = Mockery::mock('League\CLImate\Util\System\Linux');
        $system->shouldReceive('hasAnsiSupport')->andReturn(true);
        $system->shouldReceive('width')->andReturn(80);

        $this->util   = new \League\CLImate\Util\UtilFactory($system);
        $this->output = Mockery::mock('League\CLImate\Util\Output');
        $this->reader = Mockery::mock('League\CLImate\Util\Reader\Stdin');

        $this->cli = new League\CLImate\CLImate();
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
