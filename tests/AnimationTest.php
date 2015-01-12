<?php

require_once 'TestBase.php';
require_once 'Animation/ExitToTopFrames.php';
require_once 'Animation/ExitToBottomFrames.php';

class AnimationTest extends TestBase
{

    use ExitToTopFrames, ExitToBottomFrames;

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

        $this->cli->animation('404')->exitToTop();
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

        $this->cli->animation('404')->exitToBottom();
    }

}
