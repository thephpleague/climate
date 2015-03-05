<?php

require_once 'TestBase.php';

class TabTest extends TestBase
{

    /** @test */
    public function it_can_output_a_tab()
    {
        $this->output->shouldReceive("sameLine");
        $this->shouldWrite("\e[m\t\e[0m");

        $this->shouldHavePersisted();

        $this->cli->tab();
    }

    /** @test */
    public function it_is_chainable()
    {
        $this->output->shouldReceive("sameLine");
        $this->shouldWrite("\e[m\t\e[0m");
        $this->shouldWrite("\e[mThis is indented.\e[0m");

        $this->shouldHavePersisted(2);

        $this->cli->tab()->out('This is indented.');
    }

    /** @test */
    public function it_can_accept_the_number_of_tabs_as_an_argument()
    {
        $this->output->shouldReceive("sameLine");
        $this->shouldWrite("\e[m\t\t\t\e[0m");
        $this->shouldWrite("\e[mThis is really indented.\e[0m");

        $this->shouldHavePersisted(2);

        $this->cli->tab(3)->out('This is really indented.');
    }

    /** @test */
    public function it_will_ignore_a_negative_number_of_tabs()
    {
        $this->output->shouldReceive("sameLine");
        $this->shouldWrite("\e[m\t\e[0m");

        $this->shouldHavePersisted();

        $this->cli->tab(-3);
    }

    /** @test */
    public function it_will_ignore_a_partial_number_of_tabs()
    {
        $this->output->shouldReceive("sameLine");
        $this->shouldWrite("\e[m\t\t\e[0m");

        $this->shouldHavePersisted();

        $this->cli->tab(2.7);
    }

}
