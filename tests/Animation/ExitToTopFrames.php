<?php

trait ExitToTopFrames {

    abstract protected function shouldWrite($content, $count = 1);
    abstract protected function blankLines($count = 1);

    protected function fullArtExitTop()
    {
        $this->shouldWrite("\e[m  _  _    ___  _  _\e[0m")->ordered();
        $this->shouldWrite("\e[m | || |  / _ \| || |\e[0m")->ordered();
        $this->shouldWrite("\e[m | || |_| | | | || |_\e[0m")->ordered();
        $this->shouldWrite("\e[m |__   _| | | |__   _|\e[0m")->ordered();
        $this->shouldWrite("\e[m    | | | |_| |  | |\e[0m")->ordered();
        $this->shouldWrite("\e[m    |_|  \___/   |_|\e[0m")->ordered();
    }

    protected function fullArtExitTopPlus($times = 1)
    {
        for ($i = 1; $i <= $times; $i++) {
            $this->shouldWrite("\e[m\e[6A\r\e[K  _  _    ___  _  _\e[0m")->ordered();
            $this->shouldWrite("\e[m\r\e[K | || |  / _ \| || |\e[0m")->ordered();
            $this->shouldWrite("\e[m\r\e[K | || |_| | | | || |_\e[0m")->ordered();
            $this->shouldWrite("\e[m\r\e[K |__   _| | | |__   _|\e[0m")->ordered();
            $this->shouldWrite("\e[m\r\e[K    | | | |_| |  | |\e[0m")->ordered();
            $this->shouldWrite("\e[m\r\e[K    |_|  \___/   |_|\e[0m")->ordered();
        }
    }

    protected function exitTopFrame1()
    {
        $this->shouldWrite("\e[m\e[6A\r\e[K | || |  / _ \| || |\e[0m")->ordered();
        $this->shouldWrite("\e[m\r\e[K | || |_| | | | || |_\e[0m")->ordered();
        $this->shouldWrite("\e[m\r\e[K |__   _| | | |__   _|\e[0m")->ordered();
        $this->shouldWrite("\e[m\r\e[K    | | | |_| |  | |\e[0m")->ordered();
        $this->shouldWrite("\e[m\r\e[K    |_|  \___/   |_|\e[0m")->ordered();
        $this->blankLines(1);
    }

    protected function exitTopFrame2()
    {
        $this->shouldWrite("\e[m\e[6A\r\e[K | || |_| | | | || |_\e[0m")->ordered();
        $this->shouldWrite("\e[m\r\e[K |__   _| | | |__   _|\e[0m")->ordered();
        $this->shouldWrite("\e[m\r\e[K    | | | |_| |  | |\e[0m")->ordered();
        $this->shouldWrite("\e[m\r\e[K    |_|  \___/   |_|\e[0m")->ordered();
        $this->blankLines(2);
    }

    protected function exitTopFrame3()
    {
        $this->shouldWrite("\e[m\e[6A\r\e[K |__   _| | | |__   _|\e[0m")->ordered();
        $this->shouldWrite("\e[m\r\e[K    | | | |_| |  | |\e[0m")->ordered();
        $this->shouldWrite("\e[m\r\e[K    |_|  \___/   |_|\e[0m")->ordered();
        $this->blankLines(3);
    }

    protected function exitTopFrame4()
    {
        $this->shouldWrite("\e[m\e[6A\r\e[K    | | | |_| |  | |\e[0m")->ordered();
        $this->shouldWrite("\e[m\r\e[K    |_|  \___/   |_|\e[0m")->ordered();
        $this->blankLines(4);
    }

    protected function exitTopFrame5()
    {
        $this->shouldWrite("\e[m\e[6A\r\e[K    |_|  \___/   |_|\e[0m")->ordered();
        $this->blankLines(5);
    }

    protected function exitTopFrame6()
    {
        $this->shouldWrite("\e[m\e[6A\r\e[K\e[0m")->ordered();
        $this->blankLines(5);
    }

}
