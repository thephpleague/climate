<?php

namespace League\CLImate\Tests\TerminalObject\Basic;

use League\CLImate\Tests\TestBase;
use Mockery;

class DumpTest extends TestBase
{
    /**
     * @test
     * @doesNotPerformAssertions
     */
    public function it_can_dump_a_variable()
    {
        $this->output->shouldReceive("write")->once()->with(Mockery::on(function ($content) {
            return (bool) strpos($content, "string(10) \"This thing\"");
        }));

        $this->shouldHavePersisted();

        $this->cli->dump('This thing');
    }
}
