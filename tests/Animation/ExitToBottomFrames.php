<?php

trait ExitToBottomFrames {

    abstract protected function shouldWrite($content, $count = 1);

    protected function fullArtExitBottom()
    {
        $this->shouldWrite("\e[m  _  _    ___  _  _\e[0m");
        $this->shouldWrite("\e[m | || |  / _ \| || |\e[0m");
        $this->shouldWrite("\e[m | || |_| | | | || |_\e[0m");
        $this->shouldWrite("\e[m |__   _| | | |__   _|\e[0m");
        $this->shouldWrite("\e[m    | | | |_| |  | |\e[0m");
        $this->shouldWrite("\e[m    |_|  \___/   |_|\e[0m");
    }

    protected function fullArtExitBottomPlus()
    {
        $this->shouldWrite("\e[m\e[6A\r\e[K  _  _    ___  _  _\e[0m");
        $this->shouldWrite("\e[m\r\e[K | || |  / _ \| || |\e[0m");
        $this->shouldWrite("\e[m\r\e[K | || |_| | | | || |_\e[0m");
        $this->shouldWrite("\e[m\r\e[K |__   _| | | |__   _|\e[0m");
        $this->shouldWrite("\e[m\r\e[K    | | | |_| |  | |\e[0m");
        $this->shouldWrite("\e[m\r\e[K    |_|  \___/   |_|\e[0m");
    }

    protected function exitBottomFrame1()
    {
        $this->shouldWrite("\e[m\e[6A\r\e[K\e[0m");
        $this->shouldWrite("\e[m\r\e[K  _  _    ___  _  _\e[0m");
        $this->shouldWrite("\e[m\r\e[K | || |  / _ \| || |\e[0m");
        $this->shouldWrite("\e[m\r\e[K | || |_| | | | || |_\e[0m");
        $this->shouldWrite("\e[m\r\e[K |__   _| | | |__   _|\e[0m");
        $this->shouldWrite("\e[m\r\e[K    | | | |_| |  | |\e[0m");
    }

    protected function exitBottomFrame2()
    {
        $this->shouldWrite("\e[m\e[6A\r\e[K\e[0m");
        $this->shouldWrite("\e[m\r\e[K\e[0m");
        $this->shouldWrite("\e[m\r\e[K  _  _    ___  _  _\e[0m");
        $this->shouldWrite("\e[m\r\e[K | || |  / _ \| || |\e[0m");
        $this->shouldWrite("\e[m\r\e[K | || |_| | | | || |_\e[0m");
        $this->shouldWrite("\e[m\r\e[K |__   _| | | |__   _|\e[0m");
    }

    protected function exitBottomFrame3()
    {
        $this->shouldWrite("\e[m\e[6A\r\e[K\e[0m");
        $this->shouldWrite("\e[m\r\e[K\e[0m", 2);
        $this->shouldWrite("\e[m\r\e[K  _  _    ___  _  _\e[0m");
        $this->shouldWrite("\e[m\r\e[K | || |  / _ \| || |\e[0m");
        $this->shouldWrite("\e[m\r\e[K | || |_| | | | || |_\e[0m");
    }

    protected function exitBottomFrame4()
    {
        $this->shouldWrite("\e[m\e[6A\r\e[K\e[0m");
        $this->shouldWrite("\e[m\r\e[K\e[0m", 3);
        $this->shouldWrite("\e[m\r\e[K  _  _    ___  _  _\e[0m");
        $this->shouldWrite("\e[m\r\e[K | || |  / _ \| || |\e[0m");
    }

    protected function exitBottomFrame5()
    {
        $this->shouldWrite("\e[m\e[6A\r\e[K\e[0m");
        $this->shouldWrite("\e[m\r\e[K\e[0m", 4);
        $this->shouldWrite("\e[m\r\e[K  _  _    ___  _  _\e[0m");
    }

    protected function exitBottomFrame6()
    {
        $this->shouldWrite("\e[m\e[6A\r\e[K\e[0m");
        $this->shouldWrite("\e[m\r\e[K\e[0m", 5);
    }

}
