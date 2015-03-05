<?php

require_once 'TestBase.php';

class BrTest extends TestBase
{

    /** @test */
    public function it_can_output_a_line_break()
    {
        $this->shouldWrite("\e[m\e[0m");
        $this->shouldHavePersisted();

        $this->cli->br();
    }

    /** @test */
    public function it_is_chainable()
    {
        $this->shouldWrite("\e[m\e[0m");
        $this->shouldWrite("\e[mThis is a line further down.\e[0m");
        $this->shouldHavePersisted(2);

        $this->cli->br()->out('This is a line further down.');
    }

    /** @test */
    public function it_can_accept_the_number_of_breaks_as_an_argument()
    {
        $this->shouldWrite("\e[m\e[0m", 3);
        $this->shouldWrite("\e[mThis is a line further down.\e[0m");
        $this->shouldHavePersisted(2);

        $this->cli->br(3)->out('This is a line further down.');
    }

    /** @test */
    public function it_will_ignore_a_negative_number_of_breaks()
    {
        $this->shouldWrite("\e[m\e[0m");
        $this->shouldWrite("\e[mThis is a line further down.\e[0m");
        $this->shouldHavePersisted(2);

        $this->cli->br(-3)->out('This is a line further down.');
    }

    /** @test */
    public function it_will_ignore_a_partial_number_of_breaks()
    {
        $this->shouldWrite("\e[m\e[0m", 4);
        $this->shouldWrite("\e[mThis is a line further down.\e[0m");
        $this->shouldHavePersisted(2);

        $this->cli->br(4.2)->out('This is a line further down.');
    }

}
