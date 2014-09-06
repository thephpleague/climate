<?php

require_once 'TestBase.php';

class CLImateTest extends TestBase
{

    /** @test */

    public function it_can_echo_out_a_string()
    {
        ob_start();

        $this->cli->out('This would go out to the console.');
        $result = ob_get_contents();

        ob_end_clean();

        $this->assertSame("\e[mThis would go out to the console.\e[0m\n", $result);
    }

    /** @test */

    public function it_can_chain_the_out_method()
    {
        ob_start();

        $this->cli->out('This is a line.')->out('This is another line.');

        $result = ob_get_contents();

        ob_end_clean();

        $should_be = "\e[mThis is a line.\e[0m\n";
        $should_be .= "\e[mThis is another line.\e[0m\n";

        $this->assertSame($should_be, $result);
    }

}
