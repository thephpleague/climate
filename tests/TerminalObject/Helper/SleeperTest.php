<?php

namespace League\CLImate\Tests\TerminalObject\Helper;

use League\CLImate\TerminalObject\Helper\Sleeper;
use League\CLImate\Tests\TestBase;

require_once 'SleeperGlobalMock.php';

class SleeperTest extends TestBase
{
    /**
     * @test
     * @doesNotPerformAssertions
     */
    public function it_can_slow_down_the_sleeper_speed()
    {
        $sleeper = new Sleeper();

        $sleeper->speed(50);

        self::$functions->shouldReceive('usleep')
                        ->once()
                        ->with(100000);

        $sleeper->sleep();
    }

    /**
     * @test
     * @doesNotPerformAssertions
     */
    public function it_can_speed_up_the_sleeper_speed()
    {
        $sleeper = new Sleeper();

        $sleeper->speed(200);

        self::$functions->shouldReceive('usleep')
                        ->once()
                        ->with(25000);

        $sleeper->sleep();
    }

    /**
     * @test
     * @doesNotPerformAssertions
     */
    public function it_will_ignore_zero_percentages()
    {
        $sleeper = new Sleeper();

        $sleeper->speed(0);

        self::$functions->shouldReceive('usleep')
                        ->once()
                        ->with(50000);

        $sleeper->sleep();
    }


    /**
     * @test
     */
    public function it_uses_whole_integers_only()
    {
        $sleeper = new Sleeper();

        $result = $sleeper->speed(33);
        self::assertSame(151515, $result);
    }
}
