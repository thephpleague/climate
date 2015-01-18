<?php

trait ExitToRightFrames {

    protected function fullArtExitRight()
    {
        $repeat = 71;

        $this->shouldWrite("\e[m  _  _   " . str_repeat(' ', $repeat) . "\e[0m");
        $this->shouldWrite("\e[m | || |  " . str_repeat(' ', $repeat) . "\e[0m");
        $this->shouldWrite("\e[m | || |_ " . str_repeat(' ', $repeat) . "\e[0m");
        $this->shouldWrite("\e[m |__   _|" . str_repeat(' ', $repeat) . "\e[0m");
        $this->shouldWrite("\e[m    | |  " . str_repeat(' ', $repeat) . "\e[0m");
        $this->shouldWrite("\e[m    |_|  " . str_repeat(' ', $repeat) . "\e[0m");
    }

    protected function exitRightFrame($frame)
    {
        $pre_repeat  = $frame;
        $post_repeat = 71 - $frame;

        $this->shouldWrite("\e[m\e[6A\r\e[K" . str_repeat(' ', $pre_repeat) . "  _  _   " . str_repeat(' ', $post_repeat) . "\e[0m");
        $this->shouldWrite("\e[m\r\e[K" . str_repeat(' ', $pre_repeat) . " | || |  " . str_repeat(' ', $post_repeat) . "\e[0m");
        $this->shouldWrite("\e[m\r\e[K" . str_repeat(' ', $pre_repeat) . " | || |_ " . str_repeat(' ', $post_repeat) . "\e[0m");
        $this->shouldWrite("\e[m\r\e[K" . str_repeat(' ', $pre_repeat) . " |__   _|" . str_repeat(' ', $post_repeat) . "\e[0m");
        $this->shouldWrite("\e[m\r\e[K" . str_repeat(' ', $pre_repeat) . "    | |  " . str_repeat(' ', $post_repeat) . "\e[0m");
        $this->shouldWrite("\e[m\r\e[K" . str_repeat(' ', $pre_repeat) . "    |_|  " . str_repeat(' ', $post_repeat) . "\e[0m");
    }

    protected function exitRightFrameEnd1()
    {
        $pre_repeat  = 72;

        $this->shouldWrite("\e[m\e[6A\r\e[K" . str_repeat(' ', $pre_repeat) . "  _  _  \e[0m");
        $this->shouldWrite("\e[m\r\e[K" . str_repeat(' ', $pre_repeat) . " | || | \e[0m");
        $this->shouldWrite("\e[m\r\e[K" . str_repeat(' ', $pre_repeat) . " | || |_\e[0m");
        $this->shouldWrite("\e[m\r\e[K" . str_repeat(' ', $pre_repeat) . " |__   _\e[0m");
        $this->shouldWrite("\e[m\r\e[K" . str_repeat(' ', $pre_repeat) . "    | | \e[0m");
        $this->shouldWrite("\e[m\r\e[K" . str_repeat(' ', $pre_repeat) . "    |_| \e[0m");
    }

    protected function exitRightFrameEnd2()
    {
        $pre_repeat  = 73;

        $this->shouldWrite("\e[m\e[6A\r\e[K" . str_repeat(' ', $pre_repeat) . "  _  _ \e[0m");
        $this->shouldWrite("\e[m\r\e[K" . str_repeat(' ', $pre_repeat) . " | || |\e[0m", 2);
        $this->shouldWrite("\e[m\r\e[K" . str_repeat(' ', $pre_repeat) . " |__   \e[0m");
        $this->shouldWrite("\e[m\r\e[K" . str_repeat(' ', $pre_repeat) . "    | |\e[0m");
        $this->shouldWrite("\e[m\r\e[K" . str_repeat(' ', $pre_repeat) . "    |_|\e[0m");
    }

    protected function exitRightFrameEnd3()
    {
        $pre_repeat  = 74;

        $this->shouldWrite("\e[m\e[6A\r\e[K" . str_repeat(' ', $pre_repeat) . "  _  _\e[0m");
        $this->shouldWrite("\e[m\r\e[K" . str_repeat(' ', $pre_repeat) . " | || \e[0m", 2);
        $this->shouldWrite("\e[m\r\e[K" . str_repeat(' ', $pre_repeat) . " |__  \e[0m");
        $this->shouldWrite("\e[m\r\e[K" . str_repeat(' ', $pre_repeat) . "    | \e[0m");
        $this->shouldWrite("\e[m\r\e[K" . str_repeat(' ', $pre_repeat) . "    |_\e[0m");
    }

    protected function exitRightFrameEnd4()
    {
        $pre_repeat  = 75;

        $this->shouldWrite("\e[m\e[6A\r\e[K" . str_repeat(' ', $pre_repeat) . "  _  \e[0m");
        $this->shouldWrite("\e[m\r\e[K" . str_repeat(' ', $pre_repeat) . " | ||\e[0m", 2);
        $this->shouldWrite("\e[m\r\e[K" . str_repeat(' ', $pre_repeat) . " |__ \e[0m");
        $this->shouldWrite("\e[m\r\e[K" . str_repeat(' ', $pre_repeat) . "    |\e[0m", 2);
    }

    protected function exitRightFrameEnd5()
    {
        $pre_repeat  = 76;

        $this->shouldWrite("\e[m\e[6A\r\e[K" . str_repeat(' ', $pre_repeat) . "  _ \e[0m");
        $this->shouldWrite("\e[m\r\e[K" . str_repeat(' ', $pre_repeat) . " | |\e[0m", 2);
        $this->shouldWrite("\e[m\r\e[K" . str_repeat(' ', $pre_repeat) . " |__\e[0m");
        $this->shouldWrite("\e[m\r\e[K" . str_repeat(' ', $pre_repeat) . "    \e[0m", 2);
    }

    protected function exitRightFrameEnd6()
    {
        $pre_repeat  = 77;

        $this->shouldWrite("\e[m\e[6A\r\e[K" . str_repeat(' ', $pre_repeat) . "  _\e[0m");
        $this->shouldWrite("\e[m\r\e[K" . str_repeat(' ', $pre_repeat) . " | \e[0m", 2);
        $this->shouldWrite("\e[m\r\e[K" . str_repeat(' ', $pre_repeat) . " |_\e[0m");
        $this->shouldWrite("\e[m\r\e[K" . str_repeat(' ', $pre_repeat) . "   \e[0m", 2);
    }

    protected function exitRightFrameEnd7()
    {
        $pre_repeat  = 78;

        $this->shouldWrite("\e[m\e[6A\r\e[K" . str_repeat(' ', $pre_repeat) . "  \e[0m");
        $this->shouldWrite("\e[m\r\e[K" . str_repeat(' ', $pre_repeat) . " |\e[0m", 3);
        $this->shouldWrite("\e[m\r\e[K" . str_repeat(' ', $pre_repeat) . "  \e[0m", 2);
    }

    protected function exitRightFrameEnd8()
    {
        $pre_repeat  = 79;

        $this->shouldWrite("\e[m\e[6A\r\e[K" . str_repeat(' ', $pre_repeat) . " \e[0m");
        $this->shouldWrite("\e[m\r\e[K" . str_repeat(' ', $pre_repeat) . " \e[0m", 5);
    }

    protected function exitRightFrameEnd9()
    {
        $this->shouldWrite("\e[m\e[6A\r\e[K\e[0m");
        $this->shouldWrite("\e[m\r\e[K\e[0m", 5);
    }

}
