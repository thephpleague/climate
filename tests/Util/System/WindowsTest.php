<?php

namespace League\CLImate\Tests\Util\System;

use League\CLImate\Util\System\Windows;
use League\CLImate\Tests\TestBase;
use Mockery;

class WindowsTest extends TestBase
{
    /** @test */
    public function it_can_get_the_width()
    {
        $system = Mockery::mock(Windows::class)
                            ->makePartial()
                            ->shouldAllowMockingProtectedMethods();

        $system->shouldReceive('exec')->with('mode CON', true)->andReturn(['Height: 100', 'Width: 50']);

        $this->assertEquals(50, $system->width());
    }

    /** @test */
    public function it_will_return_null_if_width_is_not_numeric()
    {
        $system = Mockery::mock(Windows::class)
                            ->makePartial()
                            ->shouldAllowMockingProtectedMethods();

        $system->shouldReceive('exec')->with('mode CON', true)->andReturn('error');

        $this->assertNull($system->width());
    }

    /** @test */
    public function it_can_get_the_height()
    {
        $system = Mockery::mock(Windows::class)
                            ->makePartial()
                            ->shouldAllowMockingProtectedMethods();

        $system->shouldReceive('exec')->with('mode CON', true)->andReturn(['Height: 100', 'Width: 50']);

        $this->assertEquals(100, $system->height());
    }

    /** @test */
    public function it_will_return_null_if_height_is_not_numeric()
    {
        $system = Mockery::mock(Windows::class)
                            ->makePartial()
                            ->shouldAllowMockingProtectedMethods();

        $system->shouldReceive('exec')->with('mode CON', true)->andReturn('error');

        $this->assertNull($system->height());
    }
}
