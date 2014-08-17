<?php

class BorderTest extends PHPUnit_Framework_TestCase
{
    public $cli;

    public function setUp()
    {
        $this->cli = new JoeTannenbaum\CLImate\CLImate;
    }

    /** @test */

    public function it_can_output_a_basic_border()
    {
        ob_start();

        $this->cli->border();

        $result = ob_get_contents();

        ob_end_clean();

        $should_be = "--------------------";
        $should_be .= "--------------------";
        $should_be .= "--------------------";
        $should_be .= "--------------------";
        $should_be .= "--------------------";

        $should_be = "\e[m" . $should_be . "\e[0m\n";

        $this->assertEquals( $should_be, $result );
    }

    /** @test */

    public function it_can_output_a_border_with_a_different_character()
    {
        ob_start();

        $this->cli->border( '@' );

        $result = ob_get_contents();

        ob_end_clean();

        $should_be = "@@@@@@@@@@@@@@@@@@@@";
        $should_be .= "@@@@@@@@@@@@@@@@@@@@";
        $should_be .= "@@@@@@@@@@@@@@@@@@@@";
        $should_be .= "@@@@@@@@@@@@@@@@@@@@";
        $should_be .= "@@@@@@@@@@@@@@@@@@@@";

        $should_be = "\e[m" . $should_be . "\e[0m\n";

        $this->assertEquals( $should_be, $result );
    }

    /** @test */

    public function it_can_output_a_border_with_a_different_length()
    {
        ob_start();

        $this->cli->border( '-', 60 );

        $result = ob_get_contents();

        ob_end_clean();

        $should_be = "--------------------";
        $should_be .= "--------------------";
        $should_be .= "--------------------";

        $should_be = "\e[m" . $should_be . "\e[0m\n";

        $this->assertEquals( $should_be, $result );
    }

    /** @test */

    public function it_can_output_a_border_with_an_odd_length_character()
    {
        ob_start();

        $this->cli->border( '-*-', 50 );

        $result = ob_get_contents();

        ob_end_clean();

        $should_be = "-*--*--*--*--*--*--*--*--*--*--*--*--*--*--*--*--*";

        $should_be = "\e[m" . $should_be . "\e[0m\n";

        $this->assertEquals( $should_be, $result );
    }

    /** @test */

    public function it_can_output_a_colored_border_via_a_chained_method()
    {
        ob_start();

        $this->cli->red()->border();

        $result = ob_get_contents();

        ob_end_clean();

        $should_be = "--------------------";
        $should_be .= "--------------------";
        $should_be .= "--------------------";
        $should_be .= "--------------------";
        $should_be .= "--------------------";

        $should_be = "\e[31m" . $should_be . "\e[0m\n";

        $this->assertEquals( $should_be, $result );
    }

    /** @test */

    public function it_can_output_a_colored_border_via_a_method()
    {
        ob_start();

        $this->cli->redBorder();

        $result = ob_get_contents();

        ob_end_clean();

        $should_be = "--------------------";
        $should_be .= "--------------------";
        $should_be .= "--------------------";
        $should_be .= "--------------------";
        $should_be .= "--------------------";

        $should_be = "\e[31m" . $should_be . "\e[0m\n";

        $this->assertEquals( $should_be, $result );
    }

    /** @test */

    public function it_can_output_a_background_colored_border_via_a_chained_method()
    {
        ob_start();

        $this->cli->backgroundRed()->border();

        $result = ob_get_contents();

        ob_end_clean();

        $should_be = "--------------------";
        $should_be .= "--------------------";
        $should_be .= "--------------------";
        $should_be .= "--------------------";
        $should_be .= "--------------------";

        $should_be = "\e[41m" . $should_be . "\e[0m\n";

        $this->assertEquals( $should_be, $result );
    }

    /** @test */

    public function it_can_output_a_formatted_border_via_a_chained_method()
    {
        ob_start();

        $this->cli->blink()->border();

        $result = ob_get_contents();

        ob_end_clean();

        $should_be = "--------------------";
        $should_be .= "--------------------";
        $should_be .= "--------------------";
        $should_be .= "--------------------";
        $should_be .= "--------------------";

        $should_be = "\e[5m" . $should_be . "\e[0m\n";

        $this->assertEquals( $should_be, $result );
    }

}