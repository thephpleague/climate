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

    public function it_resets_itself_after_styled_output()
    {
        ob_start();

        $this->cli->red('This would go out to the console.');
        $this->cli->out('This is plain.');
        $result = ob_get_contents();

        ob_end_clean();

        $should_be = "\e[31mThis would go out to the console.\e[0m\n";
        $should_be .= "\e[mThis is plain.\e[0m\n";

        $this->assertEquals( $should_be, $result );
    }

    /** @test */

    public function it_can_use_a_background_color_method()
    {
        ob_start();

        $this->cli->backgroundRed('This would go out to the console.');
        $result = ob_get_contents();

        ob_end_clean();

        $this->assertEquals( "\e[41mThis would go out to the console.\e[0m\n", $result );
    }

    /** @test */

    public function it_can_use_a_background_color_method_chained()
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

    public function it_can_apply_multiple_formats()
    {
        ob_start();

        $this->cli->underline()->blink('This would go out to the console.');
        $result = ob_get_contents();

        ob_end_clean();

        $this->assertEquals( "\e[4;5mThis would go out to the console.\e[0m\n", $result );
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

    public function it_can_parse_nested_tags()
    {
        ob_start();

        $this->cli->out('This <red><blink>would</blink></red> go out to the console.');
        $result = ob_get_contents();

        ob_end_clean();

        $this->assertEquals( "\e[mThis \e[31m\e[5mwould\e[0m\e[m\e[0m\e[m go out to the console.\e[0m\n", $result );
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

    /** @test */

    public function it_can_add_a_color_and_use_it()
    {
        ob_start();

        $this->cli->style->addColor( 'new_custom_color', 900 );

        $this->cli->newCustomColor('This is the new color.');

        $result = ob_get_contents();

        ob_end_clean();

        $this->assertEquals( "\e[900mThis is the new color.\e[0m\n", $result );
    }

    /** @test */

    public function it_can_add_a_color_and_use_it_as_a_tag()
    {
        ob_start();

        $this->cli->style->addColor( 'new_custom_color', 900 );

        $this->cli->out('This <new_custom_color>is</new_custom_color> the new color.');

        $result = ob_get_contents();

        ob_end_clean();

        $this->assertEquals( "\e[mThis \e[900mis\e[0m\e[m the new color.\e[0m\n", $result );
    }

    /** @test */

    public function it_can_add_a_color_and_use_it_as_a_background()
    {
        ob_start();

        $this->cli->style->addColor( 'new_custom_color', 900 );

        $this->cli->backgroundNewCustomColor()->out('This is the new color.');

        $result = ob_get_contents();

        ob_end_clean();

        $this->assertEquals( "\e[910mThis is the new color.\e[0m\n", $result );
    }

    /** @test */

    public function it_can_use_a_color_command()
    {
        ob_start();

        $this->cli->error('This would go out to the console.');

        $result = ob_get_contents();

        ob_end_clean();

        $this->assertEquals( "\e[91mThis would go out to the console.\e[0m\n", $result );
    }

    /** @test */

    public function it_can_chain_a_color_command()
    {
        ob_start();

        $this->cli->error()->out('This would go out to the console.');

        $result = ob_get_contents();

        ob_end_clean();

        $this->assertEquals( "\e[91mThis would go out to the console.\e[0m\n", $result );
    }

    /** @test */

    public function it_can_use_add_a_color_command()
    {
        ob_start();

        $this->cli->style->addCommandColor( 'holler', 'light_blue' );

        $this->cli->holler('This would go out to the console.');

        $result = ob_get_contents();

        ob_end_clean();

        $this->assertEquals( "\e[94mThis would go out to the console.\e[0m\n", $result );
    }

    /**
     * @test
     * @expectedException        Exception
     * @expectedExceptionMessage The color 'not_a_color' for command 'holler' is not defined.
     */

    public function it_errors_when_command_color_is_not_defined()
    {
        $this->cli->style->addCommandColor( 'holler', 'not_a_color' );
    }

}