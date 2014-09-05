<?php

require_once 'TestBase.php';

class BorderTest extends TestBase
{
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

        $this->assertSame( $should_be, $result );
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

        $this->assertSame( $should_be, $result );
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

        $this->assertSame( $should_be, $result );
    }

    /** @test */

    public function it_can_output_a_border_with_an_odd_length_character_and_still_be_the_correct_length()
    {
        ob_start();

        $this->cli->border( '-*-', 50 );

        $result = ob_get_contents();

        ob_end_clean();

        $should_be = "-*--*--*--*--*--*--*--*--*--*--*--*--*--*--*--*--*";

        $should_be = "\e[m" . $should_be . "\e[0m\n";

        $this->assertSame( $should_be, $result );
    }

}