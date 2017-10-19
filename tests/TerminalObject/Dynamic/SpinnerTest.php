<?php

namespace League\CLImate\Tests\TerminalObject\Dynamic;

use League\CLImate\Tests\TestBase;
use function usleep;

class SpinnerTest extends TestBase
{

    private function wait()
    {
        usleep(100000);
    }


    public function testBasic()
    {
        $this->shouldWrite("\e[m[-=---]\e[0m");
        $this->shouldWrite("\e[m\e[1A\r\e[K[--=--]\e[0m");
        $this->shouldWrite("\e[m\e[1A\r\e[K[---=-]\e[0m");

        $spinner = $this->cli->spinner();

        $spinner->advance();

        $this->wait();
        $spinner->advance();

        $this->wait();
        $spinner->advance();
    }


    public function testQuick()
    {
        $this->shouldWrite("\e[m[-=---]\e[0m");

        $spinner = $this->cli->spinner();

        $spinner->advance();
        $spinner->advance();
    }


    public function testWithLabels()
    {
        $this->shouldWrite("\e[m[-=---] one\e[0m");
        $this->shouldWrite("\e[m\e[1A\r\e[K[--=--] two\e[0m");
        $this->shouldWrite("\e[m\e[1A\r\e[K[---=-] three\e[0m");

        $spinner = $this->cli->spinner();

        $spinner->advance("one");

        $this->wait();
        $spinner->advance("two");

        $this->wait();
        $spinner->advance("three");
    }


    public function testWithOptionalLabels()
    {
        $this->shouldWrite("\e[m[-=---] one\e[0m");
        $this->shouldWrite("\e[m\e[1A\r\e[K[--=--]\e[0m");
        $this->shouldWrite("\e[m\e[1A\r\e[K[---=-] three\e[0m");

        $spinner = $this->cli->spinner();

        $spinner->advance("one");

        $this->wait();
        $spinner->advance();

        $this->wait();
        $spinner->advance("three");
    }
}
