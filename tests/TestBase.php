<?php

class TestBase extends PHPUnit_Framework_TestCase
{
    public $cli;

    public $output;

    public $reader;

    public $util;

    public function setUp()
    {
        $system = Mockery::mock('League\CLImate\Util\System\Linux');
        $system->shouldReceive('hasAnsiSupport')->andReturn(true);
        $system->shouldReceive('width')->andReturn(80);

        $this->output = Mockery::mock('League\CLImate\Util\Output');
        $this->reader = Mockery::mock('League\CLImate\Util\Reader');
        $this->util   = new \League\CLImate\Util\UtilFactory($system);

        $this->cli = new League\CLImate\CLImate();
        $this->cli->setOutput($this->output);
        $this->cli->setUtil($this->util);
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
        $this->output->shouldReceive('write')->times($count)->with($content);
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

    /** @test */
    public function it_does_nothing()
    {
        // nada
    }

}
