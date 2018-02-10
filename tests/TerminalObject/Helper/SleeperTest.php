<?php

namespace League\CLImate\Tests\TerminalObject\Helper;

use League\CLImate\TerminalObject\Helper\Sleeper;
use PHPUnit\Framework\TestCase;

class SleeperTest extends TestCase
{
    public function setUp(): void
    {
        if (\PHP_OS_FAMILY === "Windows") {
            $this->markTestSkipped();
        }
    }


    private function assertSleep($expected, $speed)
    {
        $sleeper = new Sleeper();

        $sleeper->speed($speed);

        $start = microtime(true);
        $sleeper->sleep();
        $result = (microtime(true) - $start) * 1000000;

        $this->assertGreaterThan($expected * 0.9, $result);
        $this->assertLessThan($expected * 1.1, $result);
    }


    /**
     * @test
     */
    public function it_can_slow_down_the_sleeper_speed()
    {
        $this->assertSleep(100000, 50);
    }

    /**
     * @test
     */
    public function it_can_speed_up_the_sleeper_speed()
    {
        $this->assertSleep(25000, 200);
    }

    /**
     * @test
     */
    public function it_will_ignore_zero_percentages()
    {
        $this->assertSleep(50000, 0);
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
