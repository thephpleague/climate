<?php

require_once 'TestBase.php';

class FlankTest extends TestBase
{

    /** @test */
    public function it_can_output_a_basic_flank()
    {
        $this->shouldWrite("\e[m### Flank me! ###\e[0m");
        $this->shouldHavePersisted();
        $this->cli->flank('Flank me!');
    }

    /** @test */
    public function it_can_output_a_flank_with_a_different_character()
    {
        $this->shouldWrite("\e[m--- Flank me! ---\e[0m");
        $this->shouldHavePersisted();
        $this->cli->flank('Flank me!', '-');
    }

    /** @test */
    public function it_can_output_a_flank_with_a_different_length()
    {
        $this->shouldWrite("\e[m##### Flank me! #####\e[0m");
        $this->shouldHavePersisted();
        $this->cli->flank('Flank me!', null, 5);
    }

    /** @test */
    public function it_can_output_a_flank_with_a_character_and_different_length()
    {
        $this->shouldWrite("\e[m----- Flank me! -----\e[0m");
        $this->shouldHavePersisted();
        $this->cli->flank('Flank me!', '-', 5);
    }

}
