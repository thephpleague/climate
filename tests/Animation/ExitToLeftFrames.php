<?php

trait ExitToLeftFrames {

    abstract protected function shouldWrite($content, $count = 1);
    abstract protected function blankLines($count = 1);

    protected function fullArtExitLeft()
    {
        $this->shouldWrite("\e[m  _  _   \e[0m")->ordered();
        $this->shouldWrite("\e[m | || |  \e[0m")->ordered();
        $this->shouldWrite("\e[m | || |_ \e[0m")->ordered();
        $this->shouldWrite("\e[m |__   _|\e[0m")->ordered();
        $this->shouldWrite("\e[m    | |  \e[0m")->ordered();
        $this->shouldWrite("\e[m    |_|  \e[0m")->ordered();
    }

    protected function fullArtExitLeftPlus($times = 1)
    {
        for ($i = 1; $i <= $times; $i++) {
            $this->shouldWrite("\e[m\e[6A\r\e[K  _  _   \e[0m")->ordered();
            $this->shouldWrite("\e[m\r\e[K | || |  \e[0m")->ordered();
            $this->shouldWrite("\e[m\r\e[K | || |_ \e[0m")->ordered();
            $this->shouldWrite("\e[m\r\e[K |__   _|\e[0m")->ordered();
            $this->shouldWrite("\e[m\r\e[K    | |  \e[0m")->ordered();
            $this->shouldWrite("\e[m\r\e[K    |_|  \e[0m")->ordered();
        }
    }

    protected function exitLeftFrame1()
    {
        $this->shouldWrite("\e[m\e[6A\r\e[K _  _   \e[0m")->ordered();
        $this->shouldWrite("\e[m\r\e[K| || |  \e[0m")->ordered();
        $this->shouldWrite("\e[m\r\e[K| || |_ \e[0m")->ordered();
        $this->shouldWrite("\e[m\r\e[K|__   _|\e[0m")->ordered();
        $this->shouldWrite("\e[m\r\e[K   | |  \e[0m")->ordered();
        $this->shouldWrite("\e[m\r\e[K   |_|  \e[0m")->ordered();
    }

    protected function exitLeftFrame2()
    {
        $this->shouldWrite("\e[m\e[6A\r\e[K_  _   \e[0m")->ordered();
        $this->shouldWrite("\e[m\r\e[K || |  \e[0m")->ordered();
        $this->shouldWrite("\e[m\r\e[K || |_ \e[0m")->ordered();
        $this->shouldWrite("\e[m\r\e[K__   _|\e[0m")->ordered();
        $this->shouldWrite("\e[m\r\e[K  | |  \e[0m")->ordered();
        $this->shouldWrite("\e[m\r\e[K  |_|  \e[0m")->ordered();
    }

    protected function exitLeftFrame3()
    {
        $this->shouldWrite("\e[m\e[6A\r\e[K  _   \e[0m")->ordered();
        $this->shouldWrite("\e[m\r\e[K|| |  \e[0m")->ordered();
        $this->shouldWrite("\e[m\r\e[K|| |_ \e[0m")->ordered();
        $this->shouldWrite("\e[m\r\e[K_   _|\e[0m")->ordered();
        $this->shouldWrite("\e[m\r\e[K | |  \e[0m")->ordered();
        $this->shouldWrite("\e[m\r\e[K |_|  \e[0m")->ordered();
    }

    protected function exitLeftFrame4()
    {
        $this->shouldWrite("\e[m\e[6A\r\e[K _   \e[0m")->ordered();
        $this->shouldWrite("\e[m\r\e[K| |  \e[0m")->ordered();
        $this->shouldWrite("\e[m\r\e[K| |_ \e[0m")->ordered();
        $this->shouldWrite("\e[m\r\e[K   _|\e[0m")->ordered();
        $this->shouldWrite("\e[m\r\e[K| |  \e[0m")->ordered();
        $this->shouldWrite("\e[m\r\e[K|_|  \e[0m")->ordered();
    }

    protected function exitLeftFrame5()
    {
        $this->shouldWrite("\e[m\e[6A\r\e[K_   \e[0m")->ordered();
        $this->shouldWrite("\e[m\r\e[K |  \e[0m")->ordered();
        $this->shouldWrite("\e[m\r\e[K |_ \e[0m")->ordered();
        $this->shouldWrite("\e[m\r\e[K  _|\e[0m")->ordered();
        $this->shouldWrite("\e[m\r\e[K |  \e[0m")->ordered();
        $this->shouldWrite("\e[m\r\e[K_|  \e[0m")->ordered();
    }

    protected function exitLeftFrame6()
    {
        $this->shouldWrite("\e[m\e[6A\r\e[K   \e[0m")->ordered();
        $this->shouldWrite("\e[m\r\e[K|  \e[0m")->ordered();
        $this->shouldWrite("\e[m\r\e[K|_ \e[0m")->ordered();
        $this->shouldWrite("\e[m\r\e[K _|\e[0m")->ordered();
        $this->shouldWrite("\e[m\r\e[K|  \e[0m")->ordered();
        $this->shouldWrite("\e[m\r\e[K|  \e[0m")->ordered();
    }

    protected function exitLeftFrame7()
    {
        $this->shouldWrite("\e[m\e[6A\r\e[K  \e[0m")->ordered();
        $this->shouldWrite("\e[m\r\e[K  \e[0m")->ordered();
        $this->shouldWrite("\e[m\r\e[K_ \e[0m")->ordered();
        $this->shouldWrite("\e[m\r\e[K_|\e[0m")->ordered();
        $this->shouldWrite("\e[m\r\e[K  \e[0m")->ordered();
        $this->shouldWrite("\e[m\r\e[K  \e[0m")->ordered();
    }

    protected function exitLeftFrame8()
    {
        $this->shouldWrite("\e[m\e[6A\r\e[K \e[0m")->ordered();
        $this->shouldWrite("\e[m\r\e[K \e[0m")->ordered();
        $this->shouldWrite("\e[m\r\e[K \e[0m")->ordered();
        $this->shouldWrite("\e[m\r\e[K|\e[0m")->ordered();
        $this->shouldWrite("\e[m\r\e[K \e[0m")->ordered();
        $this->shouldWrite("\e[m\r\e[K \e[0m")->ordered();
    }

    protected function exitLeftFrame9()
    {
        $this->shouldWrite("\e[m\e[6A\r\e[K\e[0m")->ordered();
        $this->blankLines(5);
    }

}
