<?php

require_once 'TestBase.php';

use League\CLImate\Util\Dimensions;

class DimensionsTest extends TestBase
{

    /** @test */
    public function it_can_determine_the_terminal_width()
    {
        $system = Mockery::mock('League\CLImate\Util\System\Linux');
        $system->shouldReceive('width')->andReturn(100);
        $dimension = new Dimensions($system);

        $this->assertSame(100, $dimension->width());
    }

    /** @test */
    public function it_will_default_to_the_standard_terminal_width()
    {
        $system = Mockery::mock('League\CLImate\Util\System\Linux');
        $system->shouldReceive('width')->andReturn(null);
        $dimension = new Dimensions($system);

        $this->assertSame(80, $dimension->width());
    }

    /** @test */
    public function it_can_determine_the_terminal_height()
    {
        $system = Mockery::mock('League\CLImate\Util\System\Linux');
        $system->shouldReceive('height')->andReturn(100);
        $dimension = new Dimensions($system);

        $this->assertSame(100, $dimension->height());
    }

    /** @test */
    public function it_will_default_to_the_standard_terminal_height()
    {
        $system = Mockery::mock('League\CLImate\Util\System\Linux');
        $system->shouldReceive('height')->andReturn(null);
        $dimension = new Dimensions($system);

        $this->assertSame(25, $dimension->height());
    }

}
