<?php

require_once 'TestBase.php';

class OutputTest extends TestBase
{

    /** @test */

    public function it_can_output_content()
    {
        $writer = Mockery::mock('League\CLImate\Util\Writer\StdOut');
        $writer->shouldReceive('write')->once()->with("Oh, hey there.\n");

        $output = new League\CLImate\Util\Output($writer);
        $output->write('Oh, hey there.');
    }

    /** @test */

    public function it_can_output_content_without_a_new_line()
    {
        $writer = Mockery::mock('League\CLImate\Util\Writer\StdOut');
        $writer->shouldReceive('write')->once()->with("Oh, hey there.");

        $output = new League\CLImate\Util\Output($writer);
        $output->sameLine()->write('Oh, hey there.');
    }

}
