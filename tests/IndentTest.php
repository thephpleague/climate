<?php

require_once 'TestBase.php';

class IndentTest extends TestBase
{

    /** @test */

    public function it_can_indent_content()
    {
        $this->shouldWrite("\e[m\tThis here.\e[0m");

        $this->cli->indent('This here.');
    }

    /** @test */

    public function it_can_indent_content_deeper()
    {
        $this->shouldWrite("\e[m\t\tThis here.\e[0m");

        $this->cli->indent('This here.', 2);
    }

    /** @test */

    public function it_can_indent_an_array_of_content()
    {
        $this->shouldWrite("\e[m\t\tThis here.\e[0m");
        $this->shouldWrite("\e[m\t\tAnd this.\e[0m");

        $this->cli->indent(['This here.', 'And this.'], 2);
    }

}
