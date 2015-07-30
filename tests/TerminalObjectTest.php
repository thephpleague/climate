<?php

namespace League\CLImate\Tests;

class TerminalObjectTest extends TestBase
{
    /** @test **/
    public function it_gracefully_handles_non_existent_objects()
    {
        $this->shouldWrite("\e[mHey there.\e[0m");

        $this->shouldHavePersisted();

        $this->cli->somethingThatDoesntExist('Hey there.');
    }

    /** @test **/
    public function it_can_chain_a_foreground_color_and_terminal_object()
    {
        $this->shouldWrite("\e[31m### Flank me! ###\e[0m");

        $this->shouldHavePersisted();

        $this->cli->red()->flank('Flank me!');
    }

    /** @test **/
    public function it_can_chain_a_background_color_and_terminal_object()
    {
        $this->shouldWrite("\e[41m### Flank me! ###\e[0m");

        $this->shouldHavePersisted();

        $this->cli->backgroundRed()->flank('Flank me!');
    }

    /** @test **/
    public function it_can_combine_a_foreground_color_and_terminal_object()
    {
        $this->shouldWrite("\e[31m### Flank me! ###\e[0m");

        $this->shouldHavePersisted();

        $this->cli->redFlank('Flank me!');
    }

    /** @test **/
    public function it_can_combine_a_background_color_and_terminal_object()
    {
        $this->shouldWrite("\e[41m### Flank me! ###\e[0m");

        $this->shouldHavePersisted();

        $this->cli->backgroundRedFlank('Flank me!');
    }

    /** @test **/
    public function it_can_chain_a_format_and_terminal_object()
    {
        $this->shouldWrite("\e[5m### Flank me! ###\e[0m");

        $this->shouldHavePersisted();

        $this->cli->blink()->flank('Flank me!');
    }

    /** @test **/
    public function it_can_combine_a_format_and_terminal_object()
    {
        $this->shouldWrite("\e[5m### Flank me! ###\e[0m");

        $this->shouldHavePersisted();

        $this->cli->blinkFlank('Flank me!');
    }

    /** @test **/
    public function it_can_combine_multiple_formats_and_terminal_object()
    {
        $this->shouldWrite("\e[4;5m### Flank me! ###\e[0m");

        $this->shouldHavePersisted();

        $this->cli->blinkUnderlineFlank('Flank me!');
    }

    /** @test **/
    public function it_can_combine_a_foreground_and_background_color_and_terminal_object()
    {
        $this->shouldWrite("\e[31;41m### Flank me! ###\e[0m");

        $this->shouldHavePersisted();

        $this->cli->redBackgroundRedFlank('Flank me!');
    }

    /** @test **/
    public function it_can_combine_a_format_and_foreground_and_background_color_and_terminal_object()
    {
        $this->shouldWrite("\e[5;31;41m### Flank me! ###\e[0m");

        $this->shouldHavePersisted();

        $this->cli->blinkRedBackgroundRedFlank('Flank me!');
    }
}
