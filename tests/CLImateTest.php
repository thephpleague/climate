<?php

namespace League\CLImate\Tests;

class CLImateTest extends TestBase
{
    /** @test */
    public function it_can_echo_out_a_string()
    {
        $this->shouldWrite("\e[mThis would go out to the console.\e[0m");
        $this->shouldHavePersisted();
        $this->cli->out('This would go out to the console.');
    }

    /** @test */
    public function it_can_chain_the_out_method()
    {
        $this->shouldWrite("\e[mThis is a line.\e[0m");
        $this->shouldWrite("\e[mThis is another line.\e[0m");
        $this->shouldHavePersisted(2);
        $this->cli->out('This is a line.')->out('This is another line.');
    }

    /** @test */
    public function it_can_write_content_to_a_different_output()
    {
        $this->shouldWrite("\e[mThis is to the buffer.\e[0m");
        $this->output->shouldReceive('defaultTo')->with('out')->once();
        $this->output->shouldReceive('once')->with('buffer')->once();
        $this->shouldHavePersisted();

        // Just double check that this is the default output
        $this->cli->output->defaultTo('out');
        $this->cli->to('buffer')->out('This is to the buffer.');
    }
}
