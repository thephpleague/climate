<?php

namespace League\CLImate\Tests\TerminalObject\Basic;

use League\CLImate\Tests\TestBase;

class ClearLineTest extends TestBase
{


    public function testClearOneLine()
    {
        $this->output->shouldReceive("sameLine")->andReturn(true);
        $this->shouldWrite("\e[m\r\e[K\e[1A\e[1B\e[0m");
        $this->shouldHavePersisted();
        $this->cli->clearLine();
    }


    public function testClearTwoLines()
    {
        $this->output->shouldReceive("sameLine")->andReturn(true);
        $this->shouldWrite("\e[m\r\e[K\e[1A\r\e[K\e[1A\e[1B\e[0m");
        $this->shouldHavePersisted();
        $this->cli->clearLine(2);
    }
}
