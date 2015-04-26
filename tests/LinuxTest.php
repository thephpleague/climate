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

    /** @test */
    public function it_can_check_for_bash_access()
    {
        $system = Mockery::mock('League\CLImate\Util\System\Linux')
                            ->makePartial()
                            ->shouldAllowMockingProtectedMethods();

        $system->shouldReceive('exec')->with("/usr/bin/env bash -c 'echo OK'")->andReturn('OK');

        $this->assertTrue($system->canAccessBash());
    }

    /** @test */
    public function it_can_check_for_bash_access_even_when_not_available()
    {
        $system = Mockery::mock('League\CLImate\Util\System\Linux')
                            ->makePartial()
                            ->shouldAllowMockingProtectedMethods();

        $system->shouldReceive('exec')->with("/usr/bin/env bash -c 'echo OK'")->andReturn('');

        $this->assertFalse($system->canAccessBash());
    }

    /** @test */
    public function it_can_output_a_prompt_with_a_hidden_response()
    {
        $system = Mockery::mock('League\CLImate\Util\System\Linux')
                            ->makePartial()
                            ->shouldAllowMockingProtectedMethods();

        $system->shouldReceive('exec')
                    ->with("/usr/bin/env bash -c 'read -s -p \"Password Please:\" response && echo \$response'")
                    ->andReturn('the response   ');

        $this->assertSame($system->hiddenResponsePrompt('Password Please:'), 'the response');
    }

}
