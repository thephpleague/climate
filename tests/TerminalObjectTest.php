<?php

class TerminalObjectTest extends PHPUnit_Framework_TestCase
{
    public $cli;

    public function setUp()
    {
        $this->cli = new JoeTannenbaum\CLImate\CLImate;
    }

    /** @test **/

    public function it_gracefully_handles_non_existent_objects()
    {
        ob_start();

        $this->cli->somethingThatDoesntExist('Hey there.');

        $result = ob_get_contents();

        ob_end_clean();

        $should_be = "\e[mHey there.\e[0m\n";

        $this->assertEquals( $should_be, $result );
    }

    /** @test **/

    public function it_can_chain_a_foreground_color_and_terminal_object()
    {
        ob_start();

        $this->cli->red()->flank('Flank me!');

        $result = ob_get_contents();

        ob_end_clean();

        $should_be = "\e[31m### Flank me! ###\e[0m\n";

        $this->assertEquals( $should_be, $result );
    }

    /** @test **/

    public function it_can_chain_a_background_color_and_terminal_object()
    {
        ob_start();

        $this->cli->backgroundRed()->flank('Flank me!');

        $result = ob_get_contents();

        ob_end_clean();

        $should_be = "\e[41m### Flank me! ###\e[0m\n";

        $this->assertEquals( $should_be, $result );
    }

    /** @test **/

    public function it_can_combine_a_foreground_color_and_terminal_object()
    {
        ob_start();

        $this->cli->redFlank('Flank me!');

        $result = ob_get_contents();

        ob_end_clean();

        $should_be = "\e[31m### Flank me! ###\e[0m\n";

        $this->assertEquals( $should_be, $result );
    }

    /** @test **/

    public function it_can_combine_a_background_color_and_terminal_object()
    {
        ob_start();

        $this->cli->backgroundRedFlank('Flank me!');

        $result = ob_get_contents();

        ob_end_clean();

        $should_be = "\e[41m### Flank me! ###\e[0m\n";

        $this->assertEquals( $should_be, $result );
    }

    /** @test **/

    public function it_can_chain_a_format_and_terminal_object()
    {
        ob_start();

        $this->cli->blink()->flank('Flank me!');

        $result = ob_get_contents();

        ob_end_clean();

        $should_be = "\e[5m### Flank me! ###\e[0m\n";

        $this->assertEquals( $should_be, $result );
    }

    /** @test **/

    public function it_can_combine_a_format_and_terminal_object()
    {
        ob_start();

        $this->cli->blinkFlank('Flank me!');

        $result = ob_get_contents();

        ob_end_clean();

        $should_be = "\e[5m### Flank me! ###\e[0m\n";

        $this->assertEquals( $should_be, $result );
    }

    /** @test **/

    public function it_can_combine_multiple_formats_and_terminal_object()
    {
        ob_start();

        $this->cli->blinkUnderlineFlank('Flank me!');

        $result = ob_get_contents();

        ob_end_clean();

        $should_be = "\e[5;4m### Flank me! ###\e[0m\n";

        $this->assertEquals( $should_be, $result );
    }

    /** @test **/

    public function it_can_combine_a_foreground_and_background_color_and_terminal_object()
    {
        ob_start();

        $this->cli->redBackgroundRedFlank('Flank me!');

        $result = ob_get_contents();

        ob_end_clean();

        $should_be = "\e[31;41m### Flank me! ###\e[0m\n";

        $this->assertEquals( $should_be, $result );
    }

    /** @test **/

    public function it_can_combine_a_format_and_foreground_and_background_color_and_terminal_object()
    {
        ob_start();

        $this->cli->blinkRedBackgroundRedFlank('Flank me!');

        $result = ob_get_contents();

        ob_end_clean();

        $should_be = "\e[5;31;41m### Flank me! ###\e[0m\n";

        $this->assertEquals( $should_be, $result );
    }

}