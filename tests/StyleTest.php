<?php

require_once 'TestBase.php';

class StyleTest extends TestBase
{

    /** @test */

    public function it_can_use_a_foreground_color_method()
    {
        $this->shouldWrite("\e[31mThis would go out to the console.\e[0m");
        $this->cli->red('This would go out to the console.');
    }

    /** @test */

    public function it_resets_itself_after_styled_output()
    {
        $this->shouldWrite("\e[31mThis would go out to the console.\e[0m");
        $this->shouldWrite("\e[mThis is plain.\e[0m");

        $this->cli->red('This would go out to the console.');
        $this->cli->out('This is plain.');
    }

    /** @test */

    public function it_can_use_a_background_color_method()
    {
        $this->shouldWrite("\e[41mThis would go out to the console.\e[0m");
        $this->cli->backgroundRed('This would go out to the console.');
    }

    /** @test */

    public function it_can_use_a_background_color_method_chained()
    {
        $this->shouldWrite("\e[41mThis would go out to the console.\e[0m");
        $this->cli->backgroundRed()->out('This would go out to the console.');
    }

    /** @test */

    public function it_can_apply_a_format()
    {
        $this->shouldWrite("\e[5mThis would go out to the console.\e[0m");
        $this->cli->blink('This would go out to the console.');
    }

    /** @test */

    public function it_can_apply_multiple_formats()
    {
        $this->shouldWrite("\e[4;5mThis would go out to the console.\e[0m");
        $this->cli->underline()->blink('This would go out to the console.');
    }

    /** @test */

    public function it_can_chain_a_foreground_color_method()
    {
        $this->shouldWrite("\e[31mThis would go out to the console.\e[0m");
        $this->cli->red()->out('This would go out to the console.');
    }

    /** @test */

    public function it_can_use_a_background_color_and_foreground_color_method()
    {
        $this->shouldWrite("\e[31;41mThis would go out to the console.\e[0m");
        $this->cli->backgroundRed()->red('This would go out to the console.');
    }

    /** @test */

    public function it_can_use_a_background_color_and_foreground_color_and_format_method()
    {
        $this->shouldWrite("\e[5;31;41mThis would go out to the console.\e[0m");
        $this->cli->backgroundRed()->blink()->red('This would go out to the console.');
    }

    /** @test */

    public function it_can_parse_foreground_color_tags()
    {
        $this->shouldWrite("\e[mThis \e[31mwould\e[0m go out to the console.\e[0m");
        $this->cli->out('This <red>would</red> go out to the console.');
    }

    /** @test */

    public function it_can_parse_background_color_tags()
    {
        $this->shouldWrite("\e[mThis \e[41mwould\e[0m go out to the console.\e[0m");
        $this->cli->out('This <background_red>would</background_red> go out to the console.');
    }

    /** @test */

    public function it_can_parse_formatting_tags()
    {
        $this->shouldWrite("\e[mThis \e[5mwould\e[0m go out to the console.\e[0m");
        $this->cli->out('This <blink>would</blink> go out to the console.');
    }

    /** @test */

    public function it_can_parse_nested_tags()
    {
        $this->shouldWrite("\e[mThis \e[31m\e[5mwould\e[0;31m (still red)\e[0m go out to the console.\e[0m");
        $this->cli->out('This <red><blink>would</blink> (still red)</red> go out to the console.');
    }

    /** @test */

    public function it_can_parse_tags_and_return_to_current_style()
    {
        $this->shouldWrite("\e[31mThis \e[5mwould\e[0;31m go out to the console.\e[0m");
        $this->cli->red('This <blink>would</blink> go out to the console.');
    }

    /** @test */

    public function it_can_add_a_color_and_use_it()
    {
        $this->shouldWrite("\e[900mThis is the new color.\e[0m");

        $this->cli->style->addColor( 'new_custom_color', 900 );
        $this->cli->newCustomColor('This is the new color.');

    }

    /** @test */

    public function it_can_add_a_color_and_use_it_as_a_tag()
    {
        $this->shouldWrite("\e[mThis \e[900mis\e[0m the new color.\e[0m");

        $this->cli->style->addColor( 'new_custom_color', 900 );
        $this->cli->out('This <new_custom_color>is</new_custom_color> the new color.');
    }

    /** @test */

    public function it_can_add_a_color_and_use_it_as_a_background()
    {
        $this->shouldWrite("\e[910mThis is the new color.\e[0m");

        $this->cli->style->addColor( 'new_custom_color', 900 );
        $this->cli->backgroundNewCustomColor()->out('This is the new color.');
    }

    /** @test */

    public function it_can_use_a_color_command()
    {
        $this->shouldWrite("\e[91mThis would go out to the console.\e[0m");
        $this->cli->error('This would go out to the console.');
    }

    /** @test */

    public function it_can_chain_a_color_command()
    {
        $this->shouldWrite("\e[91mThis would go out to the console.\e[0m");
        $this->cli->error()->out('This would go out to the console.');
    }

    /** @test */

    public function it_can_use_add_a_command_via_a_string()
    {
        $this->shouldWrite("\e[94mThis would go out to the console.\e[0m");

        $this->cli->style->addCommand('holler', 'light_blue');
        $this->cli->holler('This would go out to the console.');
    }

    /** @test */

    public function it_can_use_a_string_command_as_a_tag()
    {
        $this->shouldWrite("\e[mThis would go \e[94mout\e[0m to the console.\e[0m");

        $this->cli->style->addCommand('holler', 'light_blue');
        $this->cli->out('This would go <holler>out</holler> to the console.');
    }

    /** @test */

    public function it_can_use_add_a_command_via_an_array()
    {
        $this->shouldWrite("\e[1;4;41;94mThis would go out to the console.\e[0m");

        $command = ['light_blue', 'background_red', 'bold', 'underline'];
        $this->cli->style->addCommand('holler', $command);
        $this->cli->holler('This would go out to the console.');
    }

    /** @test */

    public function it_can_use_an_array_command_as_a_tag()
    {
        $this->shouldWrite("\e[mThis would go \e[1;4;41;94mout\e[0m to the console.\e[0m");

        $command = ['light_blue', 'background_red', 'bold', 'underline'];
        $this->cli->style->addCommand('holler', $command);
        $this->cli->out('This would go <holler>out</holler> to the console.');
    }

}
