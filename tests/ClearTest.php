<?php

require_once 'TestBase.php';

class ClearTest extends TestBase
{

    /** @test */
    public function it_can_clear_the_terminal()
    {
        $this->output->shouldReceive("sameLine")->andReturn(true);
        $this->shouldWrite("\e[m\e[H\e[2J\e[0m");
        $this->shouldHavePersisted();
        $this->cli->clear();
    }

}
