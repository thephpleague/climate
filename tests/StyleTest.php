<?php

class StyleTest extends PHPUnit_Framework_TestCase
{
    public $cli;

    public function setUp()
    {
        $this->cli = new JoeTannenbaum\CLImate\CLImate;
    }

    /** @test */

    public function it_can_echo_out_a_string()
    {
        ob_start();

        $this->cli->out('This would go out to the console.');
        $result = ob_get_contents();

        ob_end_clean();

        $this->assertEquals( "\e[mThis would go out to the console.\e[0m\n", $result );
    }

    /** @test */

    public function it_can_use_color_method()
    {
        ob_start();

        $this->cli->red('This would go out to the console.');
        $result = ob_get_contents();

        ob_end_clean();

        $this->assertEquals( "\e[31mThis would go out to the console.\e[0m\n", $result );
    }

    /** @test */

    public function it_can_use_a_background_color_method()
    {
        ob_start();

        $this->cli->backgroundRed()->out('This would go out to the console.');
        $result = ob_get_contents();

        ob_end_clean();

        $this->assertEquals( "\e[41mThis would go out to the console.\e[0m\n", $result );
    }

    /** @test */

    public function it_can_apply_a_format()
    {
        ob_start();

        $this->cli->blink('This would go out to the console.');
        $result = ob_get_contents();

        ob_end_clean();

        $this->assertEquals( "\e[5mThis would go out to the console.\e[0m\n", $result );
    }

    /** @test */

    public function it_can_chain_a_color_method()
    {
        ob_start();

        $this->cli->red()->out('This would go out to the console.');
        $result = ob_get_contents();

        ob_end_clean();

        $this->assertEquals( "\e[31mThis would go out to the console.\e[0m\n", $result );
    }

    /** @test */

    public function it_can_use_a_background_color_and_color_method()
    {
        ob_start();

        $this->cli->backgroundRed()->red('This would go out to the console.');
        $result = ob_get_contents();

        ob_end_clean();

        $this->assertEquals( "\e[31;41mThis would go out to the console.\e[0m\n", $result );
    }

    /** @test */

    public function it_can_use_a_background_color_and_color_and_format_method()
    {
        ob_start();

        $this->cli->backgroundRed()->blink()->red('This would go out to the console.');
        $result = ob_get_contents();

        ob_end_clean();

        $this->assertEquals( "\e[5;31;41mThis would go out to the console.\e[0m\n", $result );
    }

    /** @test */

    public function it_can_parse_color_tags()
    {
        ob_start();

        $this->cli->out('This <red>would</red> go out to the console.');
        $result = ob_get_contents();

        ob_end_clean();

        $this->assertEquals( "\e[mThis \e[31mwould\e[0m\e[m go out to the console.\e[0m\n", $result );
    }

    /** @test */

    public function it_can_parse_background_color_tags()
    {
        ob_start();

        $this->cli->out('This <background_red>would</background_red> go out to the console.');
        $result = ob_get_contents();

        ob_end_clean();

        $this->assertEquals( "\e[mThis \e[41mwould\e[0m\e[m go out to the console.\e[0m\n", $result );
    }

    /** @test */

    public function it_can_parse_formatting_tags()
    {
        ob_start();

        $this->cli->out('This <blink>would</blink> go out to the console.');
        $result = ob_get_contents();

        ob_end_clean();

        $this->assertEquals( "\e[mThis \e[5mwould\e[0m\e[m go out to the console.\e[0m\n", $result );
    }

    /** @test */

    public function it_can_parse_tags_and_return_to_current_style()
    {
        ob_start();

        $this->cli->red('This <blink>would</blink> go out to the console.');
        $result = ob_get_contents();

        ob_end_clean();

        $this->assertEquals( "\e[31mThis \e[5mwould\e[0m\e[31m go out to the console.\e[0m\n", $result );
    }

}