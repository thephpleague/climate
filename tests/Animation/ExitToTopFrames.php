<?php

trait ExitToTopFrames {

    abstract protected function shouldWrite($content, $count = 1);

    protected function fullArtExitTop()
    {
        $this->shouldWrite("\e[m  _  _    ___  _  _\e[0m");
        $this->shouldWrite("\e[m | || |  / _ \| || |\e[0m");
        $this->shouldWrite("\e[m | || |_| | | | || |_\e[0m");
        $this->shouldWrite("\e[m |__   _| | | |__   _|\e[0m");
        $this->shouldWrite("\e[m    | | | |_| |  | |\e[0m");
        $this->shouldWrite("\e[m    |_|  \___/   |_|\e[0m");
    }

    protected function fullArtExitTopPlus($times = 1)
    {
        $this->shouldWrite("\e[m\e[6A\r\e[K  _  _    ___  _  _\e[0m", $times);
        $this->shouldWrite("\e[m\r\e[K | || |  / _ \| || |\e[0m", $times);
        $this->shouldWrite("\e[m\r\e[K | || |_| | | | || |_\e[0m", $times);
        $this->shouldWrite("\e[m\r\e[K |__   _| | | |__   _|\e[0m", $times);
        $this->shouldWrite("\e[m\r\e[K    | | | |_| |  | |\e[0m", $times);
        $this->shouldWrite("\e[m\r\e[K    |_|  \___/   |_|\e[0m", $times);
    }

    protected function exitTopFrame1()
    {
        $this->shouldWrite("\e[m\e[6A\r\e[K | || |  / _ \| || |\e[0m");
        $this->shouldWrite("\e[m\r\e[K | || |_| | | | || |_\e[0m");
        $this->shouldWrite("\e[m\r\e[K |__   _| | | |__   _|\e[0m");
        $this->shouldWrite("\e[m\r\e[K    | | | |_| |  | |\e[0m");
        $this->shouldWrite("\e[m\r\e[K    |_|  \___/   |_|\e[0m");
        $this->shouldWrite("\e[m\r\e[K\e[0m");
    }

    protected function exitTopFrame2()
    {
        $this->shouldWrite("\e[m\e[6A\r\e[K | || |_| | | | || |_\e[0m");
        $this->shouldWrite("\e[m\r\e[K |__   _| | | |__   _|\e[0m");
        $this->shouldWrite("\e[m\r\e[K    | | | |_| |  | |\e[0m");
        $this->shouldWrite("\e[m\r\e[K    |_|  \___/   |_|\e[0m");
        $this->shouldWrite("\e[m\r\e[K\e[0m", 2);
    }

    protected function exitTopFrame3()
    {
        $this->shouldWrite("\e[m\e[6A\r\e[K |__   _| | | |__   _|\e[0m");
        $this->shouldWrite("\e[m\r\e[K    | | | |_| |  | |\e[0m");
        $this->shouldWrite("\e[m\r\e[K    |_|  \___/   |_|\e[0m");
        $this->shouldWrite("\e[m\r\e[K\e[0m", 3);
    }

    protected function exitTopFrame4()
    {
        $this->shouldWrite("\e[m\e[6A\r\e[K    | | | |_| |  | |\e[0m");
        $this->shouldWrite("\e[m\r\e[K    |_|  \___/   |_|\e[0m");
        $this->shouldWrite("\e[m\r\e[K\e[0m", 4);
    }

    protected function exitTopFrame5()
    {
        $this->shouldWrite("\e[m\e[6A\r\e[K    |_|  \___/   |_|\e[0m");
        $this->shouldWrite("\e[m\r\e[K\e[0m", 5);
    }

    protected function exitTopFrame6()
    {
        $this->shouldWrite("\e[m\e[6A\r\e[K\e[0m");
        $this->shouldWrite("\e[m\r\e[K\e[0m", 5);
    }

}
