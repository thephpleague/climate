<?php

require_once 'TestBase.php';

class BrTest extends TestBase
{

    /** @test */

    public function it_can_output_a_line_break()
    {
        ob_start();

        $this->cli->br();

        $result = ob_get_contents();

        ob_end_clean();

        $should_be = "\e[m\e[0m\n";

        $this->assertSame($should_be, $result);
    }

    /** @test */

    public function it_is_chainable()
    {
        ob_start();

        $this->cli->br()->out('This is a line further down.');

        $result = ob_get_contents();

        ob_end_clean();

        $should_be = "\e[m\e[0m\n";
        $should_be .= "\e[mThis is a line further down.\e[0m\n";

        $this->assertSame($should_be, $result);
    }

    /** @test */

    public function it_can_accept_the_number_of_breaks_as_an_argument()
    {
        ob_start();

        $this->cli->br(3)->out('This is a line further down.');

        $result = ob_get_contents();

        ob_end_clean();

        $should_be = "\e[m\e[0m\n";
        $should_be .= "\e[m\e[0m\n";
        $should_be .= "\e[m\e[0m\n";
        $should_be .= "\e[mThis is a line further down.\e[0m\n";

        $this->assertSame($should_be, $result);
    }

    /** @test */

    public function it_will_ignore_a_negative_number_of_breaks()
    {
        ob_start();

        $this->cli->br(-3)->out('This is a line further down.');

        $result = ob_get_contents();

        ob_end_clean();

        $should_be = "\e[m\e[0m\n";
        $should_be .= "\e[mThis is a line further down.\e[0m\n";

        $this->assertSame($should_be, $result);
    }

    /** @test */

    public function it_will_ignore_a_partial_number_of_breaks()
    {
        ob_start();

        $this->cli->br(4.2)->out('This is a line further down.');

        $result = ob_get_contents();

        ob_end_clean();

        $should_be = "\e[m\e[0m\n";
        $should_be .= "\e[m\e[0m\n";
        $should_be .= "\e[m\e[0m\n";
        $should_be .= "\e[m\e[0m\n";
        $should_be .= "\e[mThis is a line further down.\e[0m\n";

        $this->assertSame($should_be, $result);
    }

}
