<?php

require_once 'TestBase.php';
require_once 'Animation/ExitToTopFrames.php';
require_once 'Animation/ExitToBottomFrames.php';
require_once 'Animation/ExitToLeftFrames.php';

class AnimationTest extends TestBase
{

    use ExitToTopFrames, ExitToBottomFrames, ExitToLeftFrames;

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

        $this->cli->animation('404', $this->getSleeper(11))->exitToTop();
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

        $this->cli->animation('404', $this->getSleeper(11))->exitToBottom();
    }

    /** @test */
    public function it_can_enter_from_bottom()
    {
        $this->emptyFrame();
        $this->exitBottomFrame5();
        $this->exitBottomFrame4();
        $this->exitBottomFrame3();
        $this->exitBottomFrame2();
        $this->exitBottomFrame1();
        $this->fullArtExitBottomPlus();

        $this->cli->animation('404', $this->getSleeper(7))->enterFromBottom();
    }

    /** @test */
    public function it_can_enter_from_top()
    {
        $this->emptyFrame();
        $this->exitTopFrame5();
        $this->exitTopFrame4();
        $this->exitTopFrame3();
        $this->exitTopFrame2();
        $this->exitTopFrame1();
        $this->fullArtExitTopPlus();

        $this->cli->animation('404', $this->getSleeper(7))->enterFromTop();
    }

    /** @test */
    public function it_can_exit_to_left()
    {
        $this->fullArtExitLeft();
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
        $this->cli->animation('4', $this->getSleeper(13))->exitToLeft();
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

        $this->cli->addArt(__DIR__ . '/art');
        $this->cli->animation('4', $this->getSleeper(10))->enterFromLeft();
    }

}
