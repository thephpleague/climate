<?php

namespace League\CLImate\Tests;

class CheckboxesTest extends TestBase
{
    protected function shouldHideCursor()
    {
        $this->shouldReceiveSameLine();
        $this->shouldWrite("\e[?25l");
    }

    protected function shouldShowCursor()
    {
        $this->shouldReceiveSameLine();
        $this->shouldWrite("\e[?25h");
    }

    /** @test */
    public function it_can_select_a_checkbox()
    {
        // Select the first one
        $this->shouldReadCharAndReturn(' ');
        // Confirm entry
        $this->shouldReadCharAndReturn("\n");

        $this->shouldWrite("\e[mCurrent mood: (use <space> to select)\e[0m");
        $this->shouldWrite("\e[m❯ ○ Happy" . str_repeat(' ', 71) . "\e[0m");
        $this->shouldWrite("\e[m  ○ Sad" . str_repeat(' ', 73) . "\e[0m");
        $this->shouldReceiveSameLine();
        $this->shouldWrite("\e[m  ○ Thrilled" . str_repeat(' ', 68) . "\e[10D\e[8m\e[0m");

        $this->util->system->shouldReceive('exec')->with('stty -icanon');
        $this->util->system->shouldReceive('exec')->with('stty sane');
        $this->shouldHideCursor();

        $this->shouldReceiveSameLine();
        $this->shouldWrite("\e[2A\r");

        $this->shouldWrite("\e[m❯ ● Happy" . str_repeat(' ', 71) . "\e[0m");
        $this->shouldWrite("\e[m  ○ Sad" . str_repeat(' ', 73) . "\e[0m");
        $this->shouldReceiveSameLine();
        $this->shouldWrite("\e[m  ○ Thrilled" . str_repeat(' ', 68) . "\e[10D\e[8m\e[0m");

        $this->shouldShowCursor();

        $this->shouldReceiveSameLine();
        $this->shouldWrite("\e[0m");

        $options = ['Happy', 'Sad', 'Thrilled'];

        $input    = $this->cli->checkboxes('Current mood:', $options, $this->reader);
        $response = $input->prompt();

        $this->assertSame(['Happy'], $response);
    }

    /** @test */
    public function it_can_select_multiple_checkboxes()
    {
        // Select the first one
        $this->shouldReadCharAndReturn(' ');
        // Go down one
        $this->shouldReadCharAndReturn("\e");
        $this->shouldReadCharAndReturn("[B", 2);
        // Go down one
        $this->shouldReadCharAndReturn("\e");
        $this->shouldReadCharAndReturn("[B", 2);
        // Select the third one
        $this->shouldReadCharAndReturn(' ');
        // Confirm entry
        $this->shouldReadCharAndReturn("\n");

        $this->shouldWrite("\e[mCurrent mood: (use <space> to select)\e[0m");
        $this->shouldWrite("\e[m❯ ○ Happy" . str_repeat(' ', 71) . "\e[0m");
        $this->shouldWrite("\e[m  ○ Sad" . str_repeat(' ', 73) . "\e[0m");
        $this->shouldReceiveSameLine();
        $this->shouldWrite("\e[m  ○ Thrilled" . str_repeat(' ', 68) . "\e[10D\e[8m\e[0m");

        $this->util->system->shouldReceive('exec')->with('stty -icanon');
        $this->util->system->shouldReceive('exec')->with('stty sane');
        $this->shouldHideCursor();

        $this->shouldReceiveSameLine();
        $this->shouldWrite("\e[2A\r", 4);

        $this->shouldWrite("\e[m❯ ● Happy" . str_repeat(' ', 71) . "\e[0m");
        $this->shouldWrite("\e[m  ○ Sad" . str_repeat(' ', 73) . "\e[0m", 3);
        $this->shouldReceiveSameLine();
        $this->shouldWrite("\e[m  ○ Thrilled" . str_repeat(' ', 68) . "\e[10D\e[8m\e[0m", 2);

        $this->shouldWrite("\e[m  ● Happy" . str_repeat(' ', 71) . "\e[0m", 3);
        $this->shouldWrite("\e[m❯ ○ Sad" . str_repeat(' ', 73) . "\e[0m");
        $this->shouldReceiveSameLine();

        $this->shouldReceiveSameLine();
        $this->shouldWrite("\e[m❯ ○ Thrilled" . str_repeat(' ', 68) . "\e[10D\e[8m\e[0m");

        $this->shouldReceiveSameLine();
        $this->shouldWrite("\e[m❯ ● Thrilled" . str_repeat(' ', 68) . "\e[10D\e[8m\e[0m");

        $this->shouldShowCursor();

        $this->shouldReceiveSameLine();
        $this->shouldWrite("\e[0m");

        $options = ['Happy', 'Sad', 'Thrilled'];

        $input    = $this->cli->checkboxes('Current mood:', $options, $this->reader);
        $response = $input->prompt();

        $this->assertSame(['Happy', 'Thrilled'], $response);
    }

    /** @test */
    public function it_can_toggle_a_checkbox()
    {
        // Select the first one
        $this->shouldReadCharAndReturn(' ');
        // Un-select the first one
        $this->shouldReadCharAndReturn(' ');
        // Confirm entry
        $this->shouldReadCharAndReturn("\n");

        $this->shouldWrite("\e[mCurrent mood: (use <space> to select)\e[0m");
        $this->shouldWrite("\e[m❯ ○ Happy" . str_repeat(' ', 71) . "\e[0m", 2);
        $this->shouldWrite("\e[m  ○ Sad" . str_repeat(' ', 73) . "\e[0m", 3);
        $this->shouldReceiveSameLine();
        $this->shouldWrite("\e[m  ○ Thrilled" . str_repeat(' ', 68) . "\e[10D\e[8m\e[0m", 3);

        $this->util->system->shouldReceive('exec')->with('stty -icanon');
        $this->util->system->shouldReceive('exec')->with('stty sane');
        $this->shouldHideCursor();

        $this->shouldReceiveSameLine();
        $this->shouldWrite("\e[2A\r", 2);

        $this->shouldWrite("\e[m❯ ● Happy" . str_repeat(' ', 71) . "\e[0m");

        $this->shouldShowCursor();

        $this->shouldReceiveSameLine();
        $this->shouldWrite("\e[0m");

        $options = ['Happy', 'Sad', 'Thrilled'];

        $input    = $this->cli->checkboxes('Current mood:', $options, $this->reader);
        $response = $input->prompt();

        $this->assertSame([], $response);
    }
}
