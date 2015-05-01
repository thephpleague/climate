<?php

require_once 'TestBase.php';

class LinuxTest extends TestBase
{

    /** @test */
    public function it_can_get_the_width()
    {
        $system = Mockery::mock('League\CLImate\Util\System\Linux')
                            ->makePartial()
                            ->shouldAllowMockingProtectedMethods();

        $system->shouldReceive('exec')->with('tput cols')->andReturn(100);

        $this->assertSame(100, $system->width());
    }

    /** @test */
    public function it_will_return_null_if_width_is_not_numeric()
    {
        $system = Mockery::mock('League\CLImate\Util\System\Linux')
                            ->makePartial()
                            ->shouldAllowMockingProtectedMethods();

        $system->shouldReceive('exec')->with('tput cols')->andReturn('error');

        $this->assertNull($system->width());
    }

    /** @test */
    public function it_can_get_the_height()
    {
        $system = Mockery::mock('League\CLImate\Util\System\Linux')
                            ->makePartial()
                            ->shouldAllowMockingProtectedMethods();

        $system->shouldReceive('exec')->with('tput lines')->andReturn(100);

        $this->assertSame(100, $system->height());
    }

    /** @test */
    public function it_will_return_null_if_height_is_not_numeric()
    {
        $system = Mockery::mock('League\CLImate\Util\System\Linux')
                            ->makePartial()
                            ->shouldAllowMockingProtectedMethods();

        $system->shouldReceive('exec')->with('tput lines')->andReturn('error');

        $this->assertNull($system->height());
    }

}
