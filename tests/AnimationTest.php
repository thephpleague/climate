<?php

require_once 'TestBase.php';
require_once 'Animation/ExitToTopFrames.php';
require_once 'Animation/ExitToBottomFrames.php';
require_once 'Animation/ExitToLeftFrames.php';
require_once 'Animation/ExitToRightFrames.php';
require_once 'Animation/RunFrames.php';

class AnimationTest extends TestBase
{

    use ExitToTopFrames, ExitToBottomFrames, ExitToLeftFrames, ExitToRightFrames, RunFrames;

    protected function emptyFrame()
    {
        $this->shouldWrite("\e[m\e[0m", 6);
    }

    protected function getSleeper($count)
    {
        $sleeper = Mockery::mock('League\CLImate\TerminalObject\Helper\Sleeper');
        $sleeper->shouldReceive('sleep')->times($count);

        return $sleeper;
    }

    /** @test */
    public function it_can_exit_to_top()
    {
        $this->fullArtExitTop();
        $this->fullArtExitTopPlus();
        $this->fullArtExitTopPlus();
        $this->fullArtExitTopPlus();
        $this->exitTopFrame1();
        $this->exitTopFrame2();
        $this->exitTopFrame3();
        $this->exitTopFrame4();
        $this->exitTopFrame5();
        $this->exitTopFrame6();
        $this->exitTopFrame6();

        $this->cli->animation('404', $this->getSleeper(11))->exitTo('top');
    }

    /** @test */
    public function it_can_enter_from_top()
    {
        $this->emptyFrame();
        $this->exitTopFrame6();
        $this->exitTopFrame5();
        $this->exitTopFrame4();
        $this->exitTopFrame3();
        $this->exitTopFrame2();
        $this->exitTopFrame1();
        $this->fullArtExitTopPlus();
        $this->fullArtExitTopPlus();
        $this->fullArtExitTopPlus();
        $this->fullArtExitTopPlus();

        $this->cli->animation('404', $this->getSleeper(11))->enterFrom('top');
    }

    /** @test */
    public function it_can_exit_to_bottom()
    {
        $this->fullArtExitBottom();
        $this->fullArtExitBottomPlus();
        $this->fullArtExitBottomPlus();
        $this->fullArtExitBottomPlus();
        $this->exitBottomFrame1();
        $this->exitBottomFrame2();
        $this->exitBottomFrame3();
        $this->exitBottomFrame4();
        $this->exitBottomFrame5();
        $this->exitBottomFrame6();
        $this->exitBottomFrame6();

        $this->cli->animation('404', $this->getSleeper(11))->exitTo('bottom');
    }

    /** @test */
    public function it_can_enter_from_bottom()
    {
        $this->emptyFrame();
        $this->exitBottomFrame6();
        $this->exitBottomFrame5();
        $this->exitBottomFrame4();
        $this->exitBottomFrame3();
        $this->exitBottomFrame2();
        $this->exitBottomFrame1();
        $this->fullArtExitBottomPlus();
        $this->fullArtExitBottomPlus();
        $this->fullArtExitBottomPlus();
        $this->fullArtExitBottomPlus();

        $this->cli->animation('404', $this->getSleeper(11))->enterFrom('bottom');
    }

    /** @test */
    public function it_can_exit_to_left()
    {
        $this->fullArtExitLeft();
        $this->fullArtExitLeftPlus();
        $this->fullArtExitLeftPlus();
        $this->fullArtExitLeftPlus();
        $this->fullArtExitLeftPlus();
        $this->exitLeftFrame1();
        $this->exitLeftFrame2();
        $this->exitLeftFrame3();
        $this->exitLeftFrame4();
        $this->exitLeftFrame5();
        $this->exitLeftFrame6();
        $this->exitLeftFrame7();
        $this->exitLeftFrame8();
        $this->exitLeftFrame9();

        $this->cli->addArt(__DIR__ . '/art');
        $this->cli->animation('4', $this->getSleeper(14))->exitTo('left');
    }

    /** @test */
    public function it_can_enter_from_left()
    {
        $this->emptyFrame();
        $this->exitLeftFrame8();
        $this->exitLeftFrame7();
        $this->exitLeftFrame6();
        $this->exitLeftFrame5();
        $this->exitLeftFrame4();
        $this->exitLeftFrame3();
        $this->exitLeftFrame2();
        $this->exitLeftFrame1();
        $this->fullArtExitLeftPlus();
        $this->fullArtExitLeftPlus();
        $this->fullArtExitLeftPlus();
        $this->fullArtExitLeftPlus();
        $this->fullArtExitLeftPlus();

        $this->cli->addArt(__DIR__ . '/art');
        $this->cli->animation('4', $this->getSleeper(14))->enterFrom('left');
    }

    /** @test */
    public function it_can_exit_to_right()
    {
        $this->fullArtExitRight();
        $this->exitRightFrame(0);
        $this->exitRightFrame(0);
        $this->exitRightFrame(0);

        for ($i = 0; $i <= 71; $i++) {
            $this->exitRightFrame($i);
        }

        $this->exitRightFrameEnd1();
        $this->exitRightFrameEnd2();
        $this->exitRightFrameEnd3();
        $this->exitRightFrameEnd4();
        $this->exitRightFrameEnd5();
        $this->exitRightFrameEnd6();
        $this->exitRightFrameEnd7();
        $this->exitRightFrameEnd8();
        $this->exitRightFrameEnd9();

        $this->cli->addArt(__DIR__ . '/art');
        $this->cli->animation('4', $this->getSleeper(85))->exitTo('right');
    }

    /** @test */
    public function it_can_enter_from_right()
    {
        $this->enterRightFrame1();
        $this->exitRightFrameEnd8();
        $this->exitRightFrameEnd7();
        $this->exitRightFrameEnd6();
        $this->exitRightFrameEnd5();
        $this->exitRightFrameEnd4();
        $this->exitRightFrameEnd3();
        $this->exitRightFrameEnd2();
        $this->exitRightFrameEnd1();

        for ($i = 71; $i >= 0; $i--) {
            $this->exitRightFrame($i);
        }

        $this->exitRightFrame(0);
        $this->exitRightFrame(0);
        $this->exitRightFrame(0);
        $this->exitRightFrame(0);

        $this->cli->addArt(__DIR__ . '/art');
        $this->cli->animation('4', $this->getSleeper(85))->enterFrom('right');
    }

    /** @test */
    public function it_will_scroll_to_the_right_by_default()
    {
        $this->emptyFrame();
        $this->exitLeftFrame8();
        $this->exitLeftFrame7();
        $this->exitLeftFrame6();
        $this->exitLeftFrame5();
        $this->exitLeftFrame4();
        $this->exitLeftFrame3();
        $this->exitLeftFrame2();
        $this->exitLeftFrame1();
        $this->fullArtExitLeftPlus();

        for ($i = 0; $i <= 71; $i++) {
            $this->exitRightFrame($i);
        }

        $this->exitRightFrameEnd1();
        $this->exitRightFrameEnd2();
        $this->exitRightFrameEnd3();
        $this->exitRightFrameEnd4();
        $this->exitRightFrameEnd5();
        $this->exitRightFrameEnd6();
        $this->exitRightFrameEnd7();
        $this->exitRightFrameEnd8();
        $this->exitRightFrameEnd9();

        $this->cli->addArt(__DIR__ . '/art');
        $this->cli->animation('4', $this->getSleeper(91))->scroll();
    }

    /** @test */
    public function it_can_scroll_to_the_right()
    {
        $this->emptyFrame();
        $this->exitLeftFrame8();
        $this->exitLeftFrame7();
        $this->exitLeftFrame6();
        $this->exitLeftFrame5();
        $this->exitLeftFrame4();
        $this->exitLeftFrame3();
        $this->exitLeftFrame2();
        $this->exitLeftFrame1();
        $this->fullArtExitLeftPlus();

        for ($i = 0; $i <= 71; $i++) {
            $this->exitRightFrame($i);
        }

        $this->exitRightFrameEnd1();
        $this->exitRightFrameEnd2();
        $this->exitRightFrameEnd3();
        $this->exitRightFrameEnd4();
        $this->exitRightFrameEnd5();
        $this->exitRightFrameEnd6();
        $this->exitRightFrameEnd7();
        $this->exitRightFrameEnd8();
        $this->exitRightFrameEnd9();

        $this->cli->addArt(__DIR__ . '/art');
        $this->cli->animation('4', $this->getSleeper(91))->scroll('right');
    }

    /** @test */
    public function it_can_scroll_to_the_left()
    {
        $this->emptyFrame();
        $this->exitRightFrameEnd9();
        $this->exitRightFrameEnd8();
        $this->exitRightFrameEnd7();
        $this->exitRightFrameEnd6();
        $this->exitRightFrameEnd5();
        $this->exitRightFrameEnd4();
        $this->exitRightFrameEnd3();
        $this->exitRightFrameEnd2();
        $this->exitRightFrameEnd1();

        for ($i = 71; $i >= 0; $i--) {
            $this->exitRightFrame($i);
        }

        $this->fullArtExitLeftPlus();
        $this->exitLeftFrame1();
        $this->exitLeftFrame2();
        $this->exitLeftFrame3();
        $this->exitLeftFrame4();
        $this->exitLeftFrame5();
        $this->exitLeftFrame6();
        $this->exitLeftFrame7();
        $this->exitLeftFrame8();

        $this->cli->addArt(__DIR__ . '/art');
        $this->cli->animation('4', $this->getSleeper(91))->scroll('left');
    }

    /** @test */
    public function it_can_scroll_up()
    {
        $this->emptyFrame();
        $this->exitBottomFrame5();
        $this->exitBottomFrame4();
        $this->exitBottomFrame3();
        $this->exitBottomFrame2();
        $this->exitBottomFrame1();
        $this->fullArtExitBottomPlus();
        $this->exitTopFrame1();
        $this->exitTopFrame2();
        $this->exitTopFrame3();
        $this->exitTopFrame4();
        $this->exitTopFrame5();
        $this->exitTopFrame6();

        $this->cli->animation('404', $this->getSleeper(13))->scroll('up');
    }

    /** @test */
    public function it_can_scroll_down()
    {
        $this->exitTopFrame6();
        $this->exitTopFrame5();
        $this->exitTopFrame4();
        $this->exitTopFrame3();
        $this->exitTopFrame2();
        $this->exitTopFrame1();
        $this->fullArtExitBottomPlus();
        $this->exitBottomFrame1();
        $this->exitBottomFrame2();
        $this->exitBottomFrame3();
        $this->exitBottomFrame4();
        $this->exitBottomFrame5();
        $this->emptyFrame();

        $this->cli->animation('404', $this->getSleeper(13))->scroll('down');
    }

    /** @test */
    public function it_can_run_a_directory_animation()
    {
        $this->runFrames1();
        $this->runFrames2();
        $this->runFrames3();
        $this->runFrames4();
        $this->runFrames5();

        $this->cli->addArt(__DIR__ . '/art');
        $this->cli->animation('work-it')->run();
    }

}
