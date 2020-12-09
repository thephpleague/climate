<?php

namespace League\CLImate\Tests;

class PaddingTest extends TestBase
{
    /**
     * @test
     * @doesNotPerformAssertions
     */
    public function it_can_wrap_a_line()
    {
        $max_width = $this->util->width();
        $padding   = $this->cli->padding();

        $content   = str_repeat('a', $max_width * 2);
        $content   = substr($content, 0, ($max_width * 2) - 5);

        $this->output->shouldReceive('sameLine');
        $this->shouldWrite("\e[m" . substr($content, 0, $max_width) . "\e[0m");
        $this->shouldWrite("\e[m" . substr($content, $max_width) . ".....\e[0m");
        $this->shouldWrite("\e[m result\e[0m");

        $padding->label($content)->result('result');
    }

    /**
     * @test
     * @doesNotPerformAssertions
     */
    public function it_can_chain()
    {
        $padding = $this->cli->padding(10);

        $this->output->shouldReceive('sameLine');
        $this->shouldWrite("\e[mPad me....\e[0m");
        $this->shouldWrite("\e[m extra\e[0m");

        $padding->label('Pad me')->result('extra');
    }

    /**
     * @test
     * @doesNotPerformAssertions
     */
    public function it_can_pad_with_multiple_characters()
    {
        $padding = $this->cli->padding(10)->char('.-');

        $this->output->shouldReceive('sameLine');
        $this->shouldWrite("\e[mPad me.-.-\e[0m");
        $this->shouldWrite("\e[m extra\e[0m");

        $padding->label('Pad me')->result('extra');
    }

    /**
     * @test
     * @doesNotPerformAssertions
     */
    public function it_can_pad_with_multiple_characters_odd()
    {
        $padding = $this->cli->padding(10)->char('.-');

        $this->output->shouldReceive('sameLine');
        $this->shouldWrite("\e[mPad odd.-.\e[0m");
        $this->shouldWrite("\e[m extra\e[0m");

        $padding->label('Pad odd')->result('extra');
    }


    /**
     * @test
     * @doesNotPerformAssertions
     */
    public function it_can_pad_with_multibyte_characters()
    {
        $padding = $this->cli->padding(10);

        $this->output->shouldReceive("sameLine");
        $this->shouldWrite("\e[mЛорем.....\e[0m");
        $this->shouldWrite("\e[m END\e[0m");

        $padding->label("Лорем")->result("END");
    }

    /**
     * @test
     * @doesNotPerformAssertions
     */
    public function it_can_wrap_a_multibyte_line()
    {
        $max_width = $this->util->width();
        $padding   = $this->cli->padding();

        $content   = "Лорем" . str_repeat('a', $max_width * 2);
        $content   = mb_substr($content, 0, ($max_width * 2) - 5);

        $this->output->shouldReceive('sameLine');
        $this->shouldWrite("\e[m" . mb_substr($content, 0, $max_width) . "\e[0m");
        $this->shouldWrite("\e[m" . mb_substr($content, $max_width) . ".....\e[0m");
        $this->shouldWrite("\e[m result\e[0m");

        $padding->label($content)->result('result');
    }

}
