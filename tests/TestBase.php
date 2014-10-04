<?php

class TestBase extends PHPUnit_Framework_TestCase
{
    public $cli;

    public $output;

    public $reader;

    public function setUp()
    {
        $this->output = Mockery::mock('League\CLImate\Util\Output');
        $this->reader = Mockery::mock('League\CLImate\Util\Reader');
        $this->cli = new League\CLImate\CLImate($this->output);
    }

    public function tearDown()
    {
        Mockery::close();
    }

    protected function shouldWrite($content, $count = 1)
    {
        $this->output->shouldReceive('write')->times($count)->with($content);
    }

    protected function shouldReadAndReturn($response)
    {
        $this->reader->shouldReceive('line')->once()->andReturn($response);
    }

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
