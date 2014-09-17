<?php

require_once 'TestBase.php';

class ClearTest extends TestBase
{

    /** @test */

    public function it_can_clear_the_terminal()
    {
        ob_start();

        $this->cli->clear();

        $result = ob_get_contents();

        ob_end_clean();

        $should_be = "\e[m\e[2J\e[0m\n";

        $this->assertSame($should_be, $result);
    }

}
