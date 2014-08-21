<?php

class FlankTest extends PHPUnit_Framework_TestCase
{
    public $cli;

    public function setUp()
    {
        $this->cli = new JoeTannenbaum\CLImate\CLImate;
    }

    /** @test */

    public function it_can_output_a_basic_flank()
    {
        ob_start();

        $this->cli->flank('Flank me!');

        $result = ob_get_contents();

        ob_end_clean();

        $should_be = "\e[m### Flank me! ###\e[0m\n";

        $this->assertEquals( $should_be, $result );
    }

    /** @test */

    public function it_can_output_a_flank_with_a_different_character()
    {
        ob_start();

        $this->cli->flank('Flank me!', '-');

        $result = ob_get_contents();

        ob_end_clean();

        $should_be = "\e[m--- Flank me! ---\e[0m\n";

        $this->assertEquals( $should_be, $result );
    }

    /** @test */

    public function it_can_output_a_flank_with_a_different_length()
    {
        ob_start();

        $this->cli->flank('Flank me!', NULL, 5);

        $result = ob_get_contents();

        ob_end_clean();

        $should_be = "\e[m##### Flank me! #####\e[0m\n";

        $this->assertEquals( $should_be, $result );
    }

    /** @test */

    public function it_can_output_a_flank_with_a_character_and_different_length()
    {
        ob_start();

        $this->cli->flank('Flank me!', '-', 5);

        $result = ob_get_contents();

        ob_end_clean();

        $should_be = "\e[m----- Flank me! -----\e[0m\n";

        $this->assertEquals( $should_be, $result );
    }

    /** @test */

    public function it_can_output_a_colored_flank_via_a_chained_method()
    {
        ob_start();

        $this->cli->red()->flank('Flank me!');

        $result = ob_get_contents();

        ob_end_clean();

        $should_be = "\e[31m### Flank me! ###\e[0m\n";

        $this->assertEquals( $should_be, $result );
    }

    /** @test */

    public function it_can_output_a_colored_flank_via_a_method()
    {
        ob_start();

        $this->cli->redFlank('Flank me!');

        $result = ob_get_contents();

        ob_end_clean();

        $should_be = "\e[31m### Flank me! ###\e[0m\n";

        $this->assertEquals( $should_be, $result );
    }

    /** @test */

    public function it_can_output_a_background_colored_flank_via_a_chained_method()
    {
        ob_start();

        $this->cli->backgroundRed()->flank('Flank me!');

        $result = ob_get_contents();

        ob_end_clean();

        $should_be = "\e[41m### Flank me! ###\e[0m\n";

        $this->assertEquals( $should_be, $result );
    }

    /** @test */

    public function it_can_output_a_formatted_flank_via_a_chained_method()
    {
        ob_start();

        $this->cli->blink()->flank('Flank me!');

        $result = ob_get_contents();

        ob_end_clean();

        $should_be = "\e[5m### Flank me! ###\e[0m\n";

        $this->assertEquals( $should_be, $result );
    }

}