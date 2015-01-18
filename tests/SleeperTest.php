<?php

require_once 'TestBase.php';

class SleeperTest extends TestBase
{
    /** @test */
    public function it_can_slow_down_the_sleeper_speed()
    {
        $sleeper = new League\CLImate\TerminalObject\Helper\Sleeper();

        $speed = $sleeper->speed(50);

        $this->assertEquals(100000, $speed);
    }

    /** @test */
    public function it_can_speed_up_the_sleeper_speed()
    {
        $sleeper = new League\CLImate\TerminalObject\Helper\Sleeper();

        $speed = $sleeper->speed(200);

        $this->assertEquals(25000, $speed);
    }

    /** @test */
    public function it_will_ignore_zero_percentages()
    {
        $sleeper = new League\CLImate\TerminalObject\Helper\Sleeper();

        $speed = $sleeper->speed(0);

        $this->assertEquals(50000, $speed);
    }

}
