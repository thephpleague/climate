<?php

class BrTest extends PHPUnit_Framework_TestCase
{
    public $cli;

    public function setUp()
    {
        $this->cli = new JoeTannenbaum\CLImate\CLImate;
    }

    /** @test */

    public function it_can_output_a_line_break()
    {
        ob_start();

        $this->cli->br();

        $result = ob_get_contents();

        ob_end_clean();

        $should_be = "\e[m\e[0m\n";

        $this->assertSame( $should_be, $result );
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

        $this->assertSame( $should_be, $result );
    }

}