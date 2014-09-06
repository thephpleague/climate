<?php

require_once 'TestBase.php';

class FlankTest extends TestBase
{

    /** @test */

    public function it_can_output_a_basic_flank()
    {
        ob_start();

        $this->cli->flank('Flank me!');

        $result = ob_get_contents();

        ob_end_clean();

        $should_be = "\e[m### Flank me! ###\e[0m\n";

        $this->assertSame($should_be, $result);
    }

    /** @test */

    public function it_can_output_a_flank_with_a_different_character()
    {
        ob_start();

        $this->cli->flank('Flank me!', '-');

        $result = ob_get_contents();

        ob_end_clean();

        $should_be = "\e[m--- Flank me! ---\e[0m\n";

        $this->assertSame($should_be, $result);
    }

    /** @test */

    public function it_can_output_a_flank_with_a_different_length()
    {
        ob_start();

        $this->cli->flank('Flank me!', null, 5);

        $result = ob_get_contents();

        ob_end_clean();

        $should_be = "\e[m##### Flank me! #####\e[0m\n";

        $this->assertSame($should_be, $result);
    }

    /** @test */

    public function it_can_output_a_flank_with_a_character_and_different_length()
    {
        ob_start();

        $this->cli->flank('Flank me!', '-', 5);

        $result = ob_get_contents();

        ob_end_clean();

        $should_be = "\e[m----- Flank me! -----\e[0m\n";

        $this->assertSame($should_be, $result);
    }

}
