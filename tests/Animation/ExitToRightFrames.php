<?php

trait ExitToRightFrames {

    abstract protected function shouldWrite($content, $count = 1);

    protected function padStr($str, $pre = 0, $post = 0)
    {
        return str_repeat(' ', $pre) . $str . str_repeat(' ', $post);
    }

    protected function fullArtExitRight()
    {
        $repeat = 71;

        $this->shouldWrite("\e[m" . $this->padStr("  _  _   ", 0, $repeat) . "\e[0m");
        $this->shouldWrite("\e[m" . $this->padStr(" | || |  ", 0, $repeat) . "\e[0m");
        $this->shouldWrite("\e[m" . $this->padStr(" | || |_ ", 0, $repeat) . "\e[0m");
        $this->shouldWrite("\e[m" . $this->padStr(" |__   _|", 0, $repeat) . "\e[0m");
        $this->shouldWrite("\e[m" . $this->padStr("    | |  ", 0, $repeat) . "\e[0m");
        $this->shouldWrite("\e[m" . $this->padStr("    |_|  ", 0, $repeat) . "\e[0m");
    }

    protected function exitRightFrame($frame, $times = 1)
    {
        $pre  = $frame;
        $post = 71 - $frame;

        $this->shouldWrite("\e[m\e[6A\r\e[K" . $this->padStr("  _  _   ", $pre, $post) . "\e[0m", $times);
        $this->shouldWrite("\e[m\r\e[K" . $this->padStr(" | || |  ", $pre, $post) . "\e[0m", $times);
        $this->shouldWrite("\e[m\r\e[K" . $this->padStr(" | || |_ ", $pre, $post) . "\e[0m", $times);
        $this->shouldWrite("\e[m\r\e[K" . $this->padStr(" |__   _|", $pre, $post) . "\e[0m", $times);
        $this->shouldWrite("\e[m\r\e[K" . $this->padStr("    | |  ", $pre, $post) . "\e[0m", $times);
        $this->shouldWrite("\e[m\r\e[K" . $this->padStr("    |_|  ", $pre, $post) . "\e[0m", $times);
    }

    protected function exitRightFrameEnd1()
    {
        $pre = 72;

        $this->shouldWrite("\e[m\e[6A\r\e[K" . $this->padStr("  _  _  ", $pre) . "\e[0m");
        $this->shouldWrite("\e[m\r\e[K" . $this->padStr(" | || | ", $pre) . "\e[0m");
        $this->shouldWrite("\e[m\r\e[K" . $this->padStr(" | || |_", $pre) . "\e[0m");
        $this->shouldWrite("\e[m\r\e[K" . $this->padStr(" |__   _", $pre) . "\e[0m");
        $this->shouldWrite("\e[m\r\e[K" . $this->padStr("    | | ", $pre) . "\e[0m");
        $this->shouldWrite("\e[m\r\e[K" . $this->padStr("    |_| ", $pre) . "\e[0m");
    }

    protected function exitRightFrameEnd2()
    {
        $pre = 73;

        $this->shouldWrite("\e[m\e[6A\r\e[K" . $this->padStr("  _  _ ", $pre) . "\e[0m");
        $this->shouldWrite("\e[m\r\e[K" . $this->padStr(" | || |", $pre) . "\e[0m", 2);
        $this->shouldWrite("\e[m\r\e[K" . $this->padStr(" |__   ", $pre) . "\e[0m");
        $this->shouldWrite("\e[m\r\e[K" . $this->padStr("    | |", $pre) . "\e[0m");
        $this->shouldWrite("\e[m\r\e[K" . $this->padStr("    |_|", $pre) . "\e[0m");
    }

    protected function exitRightFrameEnd3()
    {
        $pre = 74;

        $this->shouldWrite("\e[m\e[6A\r\e[K" . $this->padStr("  _  _", $pre) . "\e[0m");
        $this->shouldWrite("\e[m\r\e[K" . $this->padStr(" | || ", $pre) . "\e[0m", 2);
        $this->shouldWrite("\e[m\r\e[K" . $this->padStr(" |__  ", $pre) . "\e[0m");
        $this->shouldWrite("\e[m\r\e[K" . $this->padStr("    | ", $pre) . "\e[0m");
        $this->shouldWrite("\e[m\r\e[K" . $this->padStr("    |_", $pre) . "\e[0m");
    }

    protected function exitRightFrameEnd4()
    {
        $pre = 75;

        $this->shouldWrite("\e[m\e[6A\r\e[K" . $this->padStr("  _  ", $pre) . "\e[0m");
        $this->shouldWrite("\e[m\r\e[K" . $this->padStr(" | ||", $pre) . "\e[0m", 2);
        $this->shouldWrite("\e[m\r\e[K" . $this->padStr(" |__ ", $pre) . "\e[0m");
        $this->shouldWrite("\e[m\r\e[K" . $this->padStr("    |", $pre) . "\e[0m", 2);
    }

    protected function exitRightFrameEnd5()
    {
        $pre = 76;

        $this->shouldWrite("\e[m\e[6A\r\e[K" . $this->padStr("  _ ", $pre) . "\e[0m");
        $this->shouldWrite("\e[m\r\e[K" . $this->padStr(" | |", $pre) . "\e[0m", 2);
        $this->shouldWrite("\e[m\r\e[K" . $this->padStr(" |__", $pre) . "\e[0m");
        $this->shouldWrite("\e[m\r\e[K" . $this->padStr("    ", $pre) . "\e[0m", 2);
    }

    protected function exitRightFrameEnd6()
    {
        $pre = 77;

        $this->shouldWrite("\e[m\e[6A\r\e[K" . $this->padStr("  _", $pre) . "\e[0m");
        $this->shouldWrite("\e[m\r\e[K" . $this->padStr(" | ", $pre) . "\e[0m", 2);
        $this->shouldWrite("\e[m\r\e[K" . $this->padStr(" |_", $pre) . "\e[0m");
        $this->shouldWrite("\e[m\r\e[K" . $this->padStr("   ", $pre) . "\e[0m", 2);
    }

    protected function exitRightFrameEnd7()
    {
        $pre = 78;

        $this->shouldWrite("\e[m\e[6A\r\e[K" . $this->padStr("  ", $pre) . "\e[0m");
        $this->shouldWrite("\e[m\r\e[K" . $this->padStr(" |", $pre) . "\e[0m", 3);
        $this->shouldWrite("\e[m\r\e[K" . $this->padStr("  ", $pre) . "\e[0m", 2);
    }

    protected function exitRightFrameEnd8()
    {
        $pre = 79;

        $this->shouldWrite("\e[m\e[6A\r\e[K" . $this->padStr(" ", $pre) . "\e[0m");
        $this->shouldWrite("\e[m\r\e[K" . $this->padStr(" ", $pre) . "\e[0m", 5);
    }

    protected function exitRightFrameEnd9()
    {
        $this->shouldWrite("\e[m\e[6A\r\e[K\e[0m");
        $this->shouldWrite("\e[m\r\e[K\e[0m", 5);
    }

    protected function enterRightFrame1()
    {
        $this->shouldWrite("\e[m\e[0m", 6);
    }

}
