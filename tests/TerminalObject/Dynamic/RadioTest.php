<?php

namespace League\CLImate\Tests\TerminalObject\Dynamic;

use League\CLImate\Tests\TestBase;

class RadioTest extends TestBase
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
    public function it_will_select_only_one_item()
    {
        // Go down one
        $this->shouldReadCharAndReturn("\e");
        $this->shouldReadCharAndReturn("[B", 2);
        // Go down one
        $this->shouldReadCharAndReturn("\e");
        $this->shouldReadCharAndReturn("[B", 2);
        // Confirm entry
        $this->shouldReadCharAndReturn("\n");

        $this->shouldWrite("\e[mCurrent mood: (press <Enter> to select)\e[0m");
        $this->shouldWrite("\e[m❯ ○ Happy" . str_repeat(' ', 71) . "\e[0m");
        $this->shouldWrite("\e[m  ○ Sad" . str_repeat(' ', 73) . "\e[0m");
        $this->shouldReceiveSameLine();
        $this->shouldWrite("\e[m  ○ Thrilled" . str_repeat(' ', 68) . "\e[10D\e[8m\e[0m");

        $this->util->system->shouldReceive('exec')->with('stty -icanon');
        $this->util->system->shouldReceive('exec')->with('stty sane');

        $this->shouldHideCursor();

        $this->shouldReceiveSameLine();
        $this->shouldWrite("\e[2A\r", 2);

        $this->shouldReceiveSameLine();
        $this->shouldWrite("\e[m  ○ Happy" . str_repeat(' ', 71) . "\e[0m", 2);
        $this->shouldWrite("\e[m❯ ○ Sad" . str_repeat(' ', 73) . "\e[0m");
        $this->shouldWrite("\e[m  ○ Thrilled" . str_repeat(' ', 68) . "\e[10D\e[8m\e[0m");

        $this->shouldReceiveSameLine();
        $this->shouldWrite("\e[m  ○ Sad" . str_repeat(' ', 73) . "\e[0m");
        $this->shouldWrite("\e[m❯ ○ Thrilled" . str_repeat(' ', 68) . "\e[10D\e[8m\e[0m");

        $this->shouldShowCursor();

        $this->shouldReceiveSameLine();
        $this->shouldWrite("\e[0m");

        $options = ['Happy', 'Sad', 'Thrilled'];

        $input    = $this->cli->radio('Current mood:', $options, $this->reader);
        $response = $input->prompt();

        $this->assertSame('Thrilled', $response);
    }
}
