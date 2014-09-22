<?php

require_once 'TestBase.php';

class OutputTest extends TestBase
{

    /** @test */

    public function it_can_output_content()
    {
        $parser = Mockery::mock('League\CLImate\Decorator\Parser');
        $parser->shouldReceive('apply')->once()->andReturn('Just some content here from the parser.');

        ob_start();

        $output = new \League\CLImate\Output('Just some content here.', $parser);

        echo $output;

        $result = ob_get_contents();

        ob_end_clean();

        $this->assertSame("Just some content here from the parser.\n", $result);
    }

    /** @test */

    public function it_can_output_content_without_a_new_line()
    {
        $parser = Mockery::mock('League\CLImate\Decorator\Parser');
        $parser->shouldReceive('apply')->once()->andReturn('Just some content here from the parser.');

        ob_start();

        $output = new \League\CLImate\Output('Just some content here.', $parser);

        $output->sameLine();

        echo $output;

        $result = ob_get_contents();

        ob_end_clean();

        $this->assertSame('Just some content here from the parser.', $result);
    }

}
