<?php

namespace League\CLImate\Tests;

use Mockery;

class AnimationTest extends TestBase
{

    use ExitToTopFrames, ExitToBottomFrames, ExitToLeftFrames, ExitToRightFrames, RunFrames;

    protected function emptyFrame()
    {
        $this->shouldWrite("\e[m\e[0m")->ordered();
        $this->shouldWrite("\e[m\e[0m")->ordered();
        $this->shouldWrite("\e[m\e[0m")->ordered();
        $this->shouldWrite("\e[m\e[0m")->ordered();
        $this->shouldWrite("\e[m\e[0m")->ordered();
        $this->shouldWrite("\e[m\e[0m")->ordered();
    }

    protected function blankLines($count = 1)
    {
        for ($i = 1; $i <= $count; $i++) {
            $this->shouldWrite("\e[m\r\e[K\e[0m")->ordered();
        }
    }

    protected function getSleeper($count)
    {
        $sleeper = Mockery::mock('League\CLImate\TerminalObject\Helper\Sleeper');
        $sleeper->shouldReceive('sleep')->times($count);

        return $sleeper;
    }

    protected function runAsc($base, $end)
    {
        for ($i = 1; $i <= $end; $i++) {
            $this->{$base . $i}();
        }
    }

    protected function runDesc($base, $end)
    {
        for ($i = $end; $i >= 1; $i--) {
            $this->{$base . $i}();
        }
    }

    protected function assertScrolledRight()
    {
        $this->assertEnteredFromLeft();
        $this->assertExitedRight();
    }

    protected function assertEnteredFromLeft()
    {
        $this->emptyFrame();

        $this->runDesc('exitLeftFrame', 8);

        $this->fullArtExitLeftPlus();
    }

    protected function assertEnteredFromRight()
    {
        $this->runDesc('exitRightFrameEnd', 8);

        for ($i = 71; $i >= 0; $i--) {
            $this->exitRightFrame($i);
        }
    }

    protected function assertExitedLeft()
    {
        $this->runAsc('exitLeftFrame', 8);
    }

    protected function assertExitedRight()
    {
        for ($i = 0; $i <= 71; $i++) {
            $this->exitRightFrame($i);
        }

        $this->runAsc('exitRightFrameEnd', 9);
    }

    /** @test */
    public function it_can_exit_to_top()
    {
        $this->fullArtExitTop();
        $this->fullArtExitTopPlus(3);

        $this->runAsc('exitTopFrame', 6);

        $this->exitTopFrame6();

        $this->cli->animation('404', $this->getSleeper(11))->exitTo('top');
    }

    /** @test */
    public function it_can_enter_from_top()
    {
        $this->emptyFrame();

        $this->runDesc('exitTopFrame', 6);

        $this->fullArtExitTopPlus(4);

        $this->cli->animation('404', $this->getSleeper(11))->enterFrom('top');
    }

    /** @test */
    public function it_can_exit_to_bottom()
    {
        $this->fullArtExitBottom();
        $this->fullArtExitBottomPlus(3);

        $this->runAsc('exitBottomFrame', 6);

        $this->exitBottomFrame6();

        $this->cli->animation('404', $this->getSleeper(11))->exitTo('bottom');
    }

    /** @test */
    public function it_can_enter_from_bottom()
    {
        $this->emptyFrame();

        $this->runDesc('exitBottomFrame', 6);

        $this->fullArtExitBottomPlus(4);

        $this->cli->animation('404', $this->getSleeper(11))->enterFrom('bottom');
    }

    /** @test */
    public function it_can_exit_to_left()
    {
        $this->fullArtExitLeft();
        $this->fullArtExitLeftPlus(4);
        $this->assertExitedLeft();
        $this->exitLeftFrame9();

        $this->cli->addArt(__DIR__ . '/art');
        $this->cli->animation('4', $this->getSleeper(14))->exitTo('left');
    }

    /** @test */
    public function it_can_enter_from_left()
    {
        $this->assertEnteredFromLeft();
        $this->fullArtExitLeftPlus(4);

        $this->cli->addArt(__DIR__ . '/art');
        $this->cli->animation('4', $this->getSleeper(14))->enterFrom('left');
    }

    /** @test */
    public function it_can_exit_to_right()
    {
        $this->fullArtExitRight();
        $this->exitRightFrame(0, 3);

        $this->assertExitedRight();

        $this->cli->addArt(__DIR__ . '/art');
        $this->cli->animation('4', $this->getSleeper(85))->exitTo('right');
    }

    /** @test */
    public function it_can_enter_from_right()
    {
        $this->enterRightFrame1();
        $this->assertEnteredFromRight();
        $this->exitRightFrame(0, 4);

        $this->cli->addArt(__DIR__ . '/art');
        $this->cli->animation('4', $this->getSleeper(85))->enterFrom('right');
    }

    /** @test */
    public function it_will_scroll_to_the_right_by_default()
    {
        $this->assertScrolledRight();

        $this->cli->addArt(__DIR__ . '/art');
        $this->cli->animation('4', $this->getSleeper(91))->scroll();
    }

    /** @test */
    public function it_can_scroll_to_the_right()
    {
        $this->assertScrolledRight();

        $this->cli->addArt(__DIR__ . '/art');
        $this->cli->animation('4', $this->getSleeper(91))->scroll('right');
    }

    /** @test */
    public function it_can_scroll_to_the_left()
    {
        $this->emptyFrame();
        $this->assertEnteredFromRight();
        $this->fullArtExitLeftPlus();
        $this->assertExitedLeft();
        $this->exitRightFrameEnd9();

        $this->cli->addArt(__DIR__ . '/art');
        $this->cli->animation('4', $this->getSleeper(91))->scroll('left');
    }

    /** @test */
    public function it_can_scroll_up()
    {
        $this->emptyFrame();

        $this->runDesc('exitBottomFrame', 5);

        $this->fullArtExitBottomPlus();

        $this->runAsc('exitTopFrame', 6);

        $this->cli->animation('404', $this->getSleeper(13))->scroll('up');
    }

    /** @test */
    public function it_can_scroll_down()
    {
        $this->emptyFrame();

        $this->runDesc('exitTopFrame', 5);

        $this->fullArtExitBottomPlus();

        $this->runAsc('exitBottomFrame', 6);

        $this->cli->animation('404', $this->getSleeper(13))->scroll('down');
    }

    /** @test */
    public function it_can_run_a_directory_animation()
    {
        $this->runAsc('runFrames', 5);

        $this->cli->addArt(__DIR__ . '/art');
        $this->cli->animation('work-it', $this->getSleeper(5))->run();
    }

}
