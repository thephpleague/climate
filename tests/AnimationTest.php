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

    protected function assertScrolledRight()
    {
        $this->assertEnteredFromLeft();
        $this->assertExitedRight();
    }

    protected function assertEnteredFromLeft()
    {
        $this->emptyFrame();

        for ($i = 8; $i >= 1; $i--) {
            $this->{'exitLeftFrame' . $i}();
        }

        $this->fullArtExitLeftPlus();
    }

    protected function assertEnteredFromRight()
    {
        for ($i = 8; $i >= 1; $i--) {
            $this->{'exitRightFrameEnd' . $i}();
        }

        for ($i = 71; $i >= 0; $i--) {
            $this->exitRightFrame($i);
        }
    }

    protected function assertExitedLeft()
    {
        for ($i = 1; $i <= 8; $i++) {
            $this->{'exitLeftFrame' . $i}();
        }
    }

    protected function assertExitedRight()
    {
        for ($i = 0; $i <= 71; $i++) {
            $this->exitRightFrame($i);
        }

        for ($i = 1; $i <= 9; $i++) {
            $this->{'exitRightFrameEnd' . $i}();
        }
    }

    /** @test */
    public function it_can_exit_to_top()
    {
        $this->fullArtExitTop();
        $this->fullArtExitTopPlus(3);

        for ($i = 1; $i <= 6; $i++) {
            $this->{'exitTopFrame' . $i}();
        }

        $this->exitTopFrame6();

        $this->cli->animation('404', $this->getSleeper(11))->exitTo('top');
    }

    /** @test */
    public function it_can_enter_from_top()
    {
        $this->emptyFrame();

        for ($i = 6; $i >= 1; $i--) {
            $this->{'exitTopFrame' . $i}();
        }

        $this->fullArtExitTopPlus(4);

        $this->cli->animation('404', $this->getSleeper(11))->enterFrom('top');
    }

    /** @test */
    public function it_can_exit_to_bottom()
    {
        $this->fullArtExitBottom();
        $this->fullArtExitBottomPlus(3);

        for ($i = 1; $i <= 6; $i++) {
            $this->{'exitBottomFrame' . $i}();
        }

        $this->exitBottomFrame6();

        $this->cli->animation('404', $this->getSleeper(11))->exitTo('bottom');
    }

    /** @test */
    public function it_can_enter_from_bottom()
    {
        $this->emptyFrame();

        for ($i = 6; $i >= 1; $i--) {
            $this->{'exitBottomFrame' . $i}();
        }

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
        $this->exitRightFrameEnd9();
        $this->assertEnteredFromRight();
        $this->fullArtExitLeftPlus();
        $this->assertExitedLeft();

        $this->cli->addArt(__DIR__ . '/art');
        $this->cli->animation('4', $this->getSleeper(91))->scroll('left');
    }

    /** @test */
    public function it_can_scroll_up()
    {
        $this->emptyFrame();

        for ($i = 5; $i >= 1; $i--) {
            $this->{'exitBottomFrame' . $i}();
        }

        $this->fullArtExitBottomPlus();

        for ($i = 1; $i <= 6; $i++) {
            $this->{'exitTopFrame' . $i}();
        }

        $this->cli->animation('404', $this->getSleeper(13))->scroll('up');
    }

    /** @test */
    public function it_can_scroll_down()
    {
        for ($i = 6; $i >= 1; $i--) {
            $this->{'exitTopFrame' . $i}();
        }

        $this->fullArtExitBottomPlus();

        for ($i = 1; $i <= 5; $i++) {
            $this->{'exitBottomFrame' . $i}();
        }

        $this->emptyFrame();

        $this->cli->animation('404', $this->getSleeper(13))->scroll('down');
    }

    /** @test */
    public function it_can_run_a_directory_animation()
    {
        for ($i = 1; $i <= 5; $i++) {
            $this->{'runFrames' . $i}();
        }

        $this->cli->addArt(__DIR__ . '/art');
        $this->cli->animation('work-it', $this->getSleeper(5))->run();
    }

}
