<?php

require_once 'TestBase.php';

class CLImateTest extends TestBase
{

    /** @test */
    public function it_can_echo_out_a_string()
    {
        $this->shouldWrite("\e[mThis would go out to the console.\e[0m");
        $this->cli->out('This would go out to the console.');
    }

    /** @test */
    public function it_can_chain_the_out_method()
    {
        $this->shouldWrite("\e[mThis is a line.\e[0m");
        $this->shouldWrite("\e[mThis is another line.\e[0m");
        $this->cli->out('This is a line.')->out('This is another line.');
    }

}
