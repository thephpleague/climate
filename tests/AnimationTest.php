<?php

require_once 'TestBase.php';

class AnimationTest extends TestBase
{
    protected function fullArt()
    {
        $this->shouldWrite("\e[m  _  _    ___  _  _\e[0m");
        $this->shouldWrite("\e[m | || |  / _ \| || |\e[0m");
        $this->shouldWrite("\e[m | || |_| | | | || |_\e[0m");
        $this->shouldWrite("\e[m |__   _| | | |__   _|\e[0m");
        $this->shouldWrite("\e[m    | | | |_| |  | |\e[0m");
        $this->shouldWrite("\e[m    |_|  \___/   |_|\e[0m");
    }

    protected function fullArtPlus()
    {
        $this->shouldWrite("\e[m\e[6A\r\e[K  _  _    ___  _  _\e[0m");
        $this->shouldWrite("\e[m\r\e[K | || |  / _ \| || |\e[0m");
        $this->shouldWrite("\e[m\r\e[K | || |_| | | | || |_\e[0m");
        $this->shouldWrite("\e[m\r\e[K |__   _| | | |__   _|\e[0m");
        $this->shouldWrite("\e[m\r\e[K    | | | |_| |  | |\e[0m");
        $this->shouldWrite("\e[m\r\e[K    |_|  \___/   |_|\e[0m");
    }

    protected function exitFrame1()
    {
        $this->shouldWrite("\e[m\e[6A\r\e[K | || |  / _ \| || |\e[0m");
        $this->shouldWrite("\e[m\r\e[K | || |_| | | | || |_\e[0m");
        $this->shouldWrite("\e[m\r\e[K |__   _| | | |__   _|\e[0m");
        $this->shouldWrite("\e[m\r\e[K    | | | |_| |  | |\e[0m");
        $this->shouldWrite("\e[m\r\e[K    |_|  \___/   |_|\e[0m");
        $this->shouldWrite("\e[m\r\e[K\e[0m");
    }

    protected function exitFrame2()
    {
        $this->shouldWrite("\e[m\e[6A\r\e[K | || |_| | | | || |_\e[0m");
        $this->shouldWrite("\e[m\r\e[K |__   _| | | |__   _|\e[0m");
        $this->shouldWrite("\e[m\r\e[K    | | | |_| |  | |\e[0m");
        $this->shouldWrite("\e[m\r\e[K    |_|  \___/   |_|\e[0m");
        $this->shouldWrite("\e[m\r\e[K\e[0m", 2);
    }

    protected function exitFrame3()
    {
        $this->shouldWrite("\e[m\e[6A\r\e[K |__   _| | | |__   _|\e[0m");
        $this->shouldWrite("\e[m\r\e[K    | | | |_| |  | |\e[0m");
        $this->shouldWrite("\e[m\r\e[K    |_|  \___/   |_|\e[0m");
        $this->shouldWrite("\e[m\r\e[K\e[0m", 3);
    }

    protected function exitFrame4()
    {
        $this->shouldWrite("\e[m\e[6A\r\e[K    | | | |_| |  | |\e[0m");
        $this->shouldWrite("\e[m\r\e[K    |_|  \___/   |_|\e[0m");
        $this->shouldWrite("\e[m\r\e[K\e[0m", 4);
    }

    protected function exitFrame5()
    {
        $this->shouldWrite("\e[m\e[6A\r\e[K    |_|  \___/   |_|\e[0m");
        $this->shouldWrite("\e[m\r\e[K\e[0m", 5);
    }

    protected function exitFrame6()
    {
        $this->shouldWrite("\e[m\e[6A\r\e[K\e[0m");
        $this->shouldWrite("\e[m\r\e[K\e[0m", 5);
    }

    /** @test */
    public function it_can_animate_something()
    {
        $this->fullArt();
        $this->fullArtPlus();
        $this->fullArtPlus();
        $this->fullArtPlus();
        $this->exitFrame1();
        $this->exitFrame2();
        $this->exitFrame3();
        $this->exitFrame4();
        $this->exitFrame5();
        $this->exitFrame6();
        $this->exitFrame6();

        $this->cli->animation('404')->exitToTop();
    }

}
