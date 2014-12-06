<?php

require_once 'TestBase.php';

class PaddingTest extends TestBase
{

    /** @test */
    public function it_can_wrap_a_line()
    {
        $max_width = $this->util->width();
        $padding   = $this->cli->padding();

        $content   = str_repeat('a', $max_width * 2);
        $content   = substr($content, 0, ($max_width * 2) - 5);

        $this->output->shouldReceive('sameLine');
        $this->shouldWrite(substr($content, 0, $max_width));
        $this->shouldWrite(substr($content, $max_width) . '.....');
        $this->shouldWrite(' result');

        $padding->label($content)->result('result');
    }

    /** @test */
    public function it_can_chain()
    {
        $padding = $this->cli->padding(10);

        $this->output->shouldReceive('sameLine');
        $this->shouldWrite('Pad me....');
        $this->shouldWrite(' extra');

        $padding->label('Pad me')->result('extra');
    }


    /** @test */
    public function it_can_pad_with_multiple_characters()
    {
        $padding = $this->cli->padding(10)->char('.-');

        $this->output->shouldReceive('sameLine');
        $this->shouldWrite('Pad me.-.-');
        $this->shouldWrite(' extra');

        $padding->label('Pad me')->result('extra');
    }


    /** @test */
    public function it_can_pad_with_multiple_characters_odd()
    {
        $padding = $this->cli->padding(10)->char('.-');

        $this->output->shouldReceive('sameLine');
        $this->shouldWrite('Pad odd.-.');
        $this->shouldWrite(' extra');

        $padding->label('Pad odd')->result('extra');
    }


}
