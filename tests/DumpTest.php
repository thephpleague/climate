<?php

require_once 'TestBase.php';

class DumpTest extends TestBase
{

    /** @test */
    public function it_can_dump_a_variable()
    {
        $should_be = [
            'string(10) "This thing"',
            ''
        ];

        $this->shouldWrite("\e[m" . implode("\n", $should_be) . "\e[0m");

        $this->cli->dump('This thing');
    }

}
