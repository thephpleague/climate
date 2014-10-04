<?php

require_once 'TestBase.php';

class ClearTest extends TestBase
{

    /** @test */

    public function it_can_clear_the_terminal()
    {
        $this->shouldWrite("\e[m\e[2J\e[0m");
        $this->cli->clear();
    }

}
