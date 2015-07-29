<?php

namespace League\CLImate\Tests;

trait ExitToRightFrames {

    abstract protected function shouldWrite($content, $count = 1);
    abstract protected function blankLines($count = 1);
    abstract protected function emptyFrame();

    protected function padStr($str, $pre = 0, $post = 0)
    {
        return str_repeat(' ', $pre) . $str . str_repeat(' ', $post);
    }

    protected function fullArtExitRight()
    {
        $repeat = 71;

        $this->shouldWrite("\e[m" . $this->padStr("  _  _   ", 0, $repeat) . "\e[0m")->ordered();
        $this->shouldWrite("\e[m" . $this->padStr(" | || |  ", 0, $repeat) . "\e[0m")->ordered();
        $this->shouldWrite("\e[m" . $this->padStr(" | || |_ ", 0, $repeat) . "\e[0m")->ordered();
        $this->shouldWrite("\e[m" . $this->padStr(" |__   _|", 0, $repeat) . "\e[0m")->ordered();
        $this->shouldWrite("\e[m" . $this->padStr("    | |  ", 0, $repeat) . "\e[0m")->ordered();
        $this->shouldWrite("\e[m" . $this->padStr("    |_|  ", 0, $repeat) . "\e[0m")->ordered();
    }

    protected function exitRightFrame($frame, $times = 1)
    {
        $pre  = $frame;
        $post = 71 - $frame;

        for ($i = 1; $i <= $times; $i++) {
            $this->shouldWrite("\e[m\e[6A\r\e[K" . $this->padStr("  _  _   ", $pre, $post) . "\e[0m")->ordered();
            $this->shouldWrite("\e[m\r\e[K" . $this->padStr(" | || |  ", $pre, $post) . "\e[0m")->ordered();
            $this->shouldWrite("\e[m\r\e[K" . $this->padStr(" | || |_ ", $pre, $post) . "\e[0m")->ordered();
            $this->shouldWrite("\e[m\r\e[K" . $this->padStr(" |__   _|", $pre, $post) . "\e[0m")->ordered();
            $this->shouldWrite("\e[m\r\e[K" . $this->padStr("    | |  ", $pre, $post) . "\e[0m")->ordered();
            $this->shouldWrite("\e[m\r\e[K" . $this->padStr("    |_|  ", $pre, $post) . "\e[0m")->ordered();
        }
    }

    protected function exitRightFrameEnd1()
    {
        $pre = 72;

        $this->shouldWrite("\e[m\e[6A\r\e[K" . $this->padStr("  _  _  ", $pre) . "\e[0m")->ordered();
        $this->shouldWrite("\e[m\r\e[K" . $this->padStr(" | || | ", $pre) . "\e[0m")->ordered();
        $this->shouldWrite("\e[m\r\e[K" . $this->padStr(" | || |_", $pre) . "\e[0m")->ordered();
        $this->shouldWrite("\e[m\r\e[K" . $this->padStr(" |__   _", $pre) . "\e[0m")->ordered();
        $this->shouldWrite("\e[m\r\e[K" . $this->padStr("    | | ", $pre) . "\e[0m")->ordered();
        $this->shouldWrite("\e[m\r\e[K" . $this->padStr("    |_| ", $pre) . "\e[0m")->ordered();
    }

    protected function exitRightFrameEnd2()
    {
        $pre = 73;

        $this->shouldWrite("\e[m\e[6A\r\e[K" . $this->padStr("  _  _ ", $pre) . "\e[0m")->ordered();
        $this->shouldWrite("\e[m\r\e[K" . $this->padStr(" | || |", $pre) . "\e[0m")->ordered();
        $this->shouldWrite("\e[m\r\e[K" . $this->padStr(" | || |", $pre) . "\e[0m")->ordered();
        $this->shouldWrite("\e[m\r\e[K" . $this->padStr(" |__   ", $pre) . "\e[0m")->ordered();
        $this->shouldWrite("\e[m\r\e[K" . $this->padStr("    | |", $pre) . "\e[0m")->ordered();
        $this->shouldWrite("\e[m\r\e[K" . $this->padStr("    |_|", $pre) . "\e[0m")->ordered();
    }

    protected function exitRightFrameEnd3()
    {
        $pre = 74;

        $this->shouldWrite("\e[m\e[6A\r\e[K" . $this->padStr("  _  _", $pre) . "\e[0m")->ordered();
        $this->shouldWrite("\e[m\r\e[K" . $this->padStr(" | || ", $pre) . "\e[0m")->ordered();
        $this->shouldWrite("\e[m\r\e[K" . $this->padStr(" | || ", $pre) . "\e[0m")->ordered();
        $this->shouldWrite("\e[m\r\e[K" . $this->padStr(" |__  ", $pre) . "\e[0m")->ordered();
        $this->shouldWrite("\e[m\r\e[K" . $this->padStr("    | ", $pre) . "\e[0m")->ordered();
        $this->shouldWrite("\e[m\r\e[K" . $this->padStr("    |_", $pre) . "\e[0m")->ordered();
    }

    protected function exitRightFrameEnd4()
    {
        $pre = 75;

        $this->shouldWrite("\e[m\e[6A\r\e[K" . $this->padStr("  _  ", $pre) . "\e[0m")->ordered();
        $this->shouldWrite("\e[m\r\e[K" . $this->padStr(" | ||", $pre) . "\e[0m")->ordered();
        $this->shouldWrite("\e[m\r\e[K" . $this->padStr(" | ||", $pre) . "\e[0m")->ordered();
        $this->shouldWrite("\e[m\r\e[K" . $this->padStr(" |__ ", $pre) . "\e[0m")->ordered();
        $this->shouldWrite("\e[m\r\e[K" . $this->padStr("    |", $pre) . "\e[0m")->ordered();
        $this->shouldWrite("\e[m\r\e[K" . $this->padStr("    |", $pre) . "\e[0m")->ordered();
    }

    protected function exitRightFrameEnd5()
    {
        $pre = 76;

        $this->shouldWrite("\e[m\e[6A\r\e[K" . $this->padStr("  _ ", $pre) . "\e[0m")->ordered();
        $this->shouldWrite("\e[m\r\e[K" . $this->padStr(" | |", $pre) . "\e[0m")->ordered();
        $this->shouldWrite("\e[m\r\e[K" . $this->padStr(" | |", $pre) . "\e[0m")->ordered();
        $this->shouldWrite("\e[m\r\e[K" . $this->padStr(" |__", $pre) . "\e[0m")->ordered();
        $this->shouldWrite("\e[m\r\e[K" . $this->padStr("    ", $pre) . "\e[0m")->ordered();
        $this->shouldWrite("\e[m\r\e[K" . $this->padStr("    ", $pre) . "\e[0m")->ordered();
    }

    protected function exitRightFrameEnd6()
    {
        $pre = 77;

        $this->shouldWrite("\e[m\e[6A\r\e[K" . $this->padStr("  _", $pre) . "\e[0m")->ordered();
        $this->shouldWrite("\e[m\r\e[K" . $this->padStr(" | ", $pre) . "\e[0m")->ordered();
        $this->shouldWrite("\e[m\r\e[K" . $this->padStr(" | ", $pre) . "\e[0m")->ordered();
        $this->shouldWrite("\e[m\r\e[K" . $this->padStr(" |_", $pre) . "\e[0m")->ordered();
        $this->shouldWrite("\e[m\r\e[K" . $this->padStr("   ", $pre) . "\e[0m")->ordered();
        $this->shouldWrite("\e[m\r\e[K" . $this->padStr("   ", $pre) . "\e[0m")->ordered();
    }

    protected function exitRightFrameEnd7()
    {
        $pre = 78;

        $this->shouldWrite("\e[m\e[6A\r\e[K" . $this->padStr("  ", $pre) . "\e[0m")->ordered();
        $this->shouldWrite("\e[m\r\e[K" . $this->padStr(" |", $pre) . "\e[0m")->ordered();
        $this->shouldWrite("\e[m\r\e[K" . $this->padStr(" |", $pre) . "\e[0m")->ordered();
        $this->shouldWrite("\e[m\r\e[K" . $this->padStr(" |", $pre) . "\e[0m")->ordered();
        $this->shouldWrite("\e[m\r\e[K" . $this->padStr("  ", $pre) . "\e[0m")->ordered();
        $this->shouldWrite("\e[m\r\e[K" . $this->padStr("  ", $pre) . "\e[0m")->ordered();
    }

    protected function exitRightFrameEnd8()
    {
        $pre = 79;

        $this->shouldWrite("\e[m\e[6A\r\e[K" . $this->padStr(" ", $pre) . "\e[0m")->ordered();
        $this->shouldWrite("\e[m\r\e[K" . $this->padStr(" ", $pre) . "\e[0m")->ordered();
        $this->shouldWrite("\e[m\r\e[K" . $this->padStr(" ", $pre) . "\e[0m")->ordered();
        $this->shouldWrite("\e[m\r\e[K" . $this->padStr(" ", $pre) . "\e[0m")->ordered();
        $this->shouldWrite("\e[m\r\e[K" . $this->padStr(" ", $pre) . "\e[0m")->ordered();
        $this->shouldWrite("\e[m\r\e[K" . $this->padStr(" ", $pre) . "\e[0m")->ordered();
    }

    protected function exitRightFrameEnd9()
    {
        $this->shouldWrite("\e[m\e[6A\r\e[K\e[0m")->ordered();
        $this->blankLines(5);
    }

    protected function enterRightFrame1()
    {
        $this->emptyFrame();
    }

}
