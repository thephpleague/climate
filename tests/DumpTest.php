<?php

namespace League\CLImate\Tests;

require_once 'VarDumpMock.php';

class DumpTest extends TestBase
{
    /** @test */
    public function it_can_dump_a_variable()
    {
        $this->shouldWrite("\e[mDUMPED: This thing\e[0m");
        $this->shouldHavePersisted();

        $this->cli->dump('This thing');
    }
}
