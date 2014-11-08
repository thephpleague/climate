<?php

require_once 'TestBase.php';

class PaddingTest extends TestBase
{

    /** @test */

    public function it_can_output_content()
    {
        $padding = $this->cli->padding(10);

        $this->shouldWrite("Pad me");
        $padding->out("Pad me");
    }


    /** @test */

    public function it_can_pad_a_line()
    {
        $padding = $this->cli->padding()->length(10);

        $this->shouldWrite("Pad me....");
        $padding->pad("Pad me");
    }


    /** @test */

    public function it_can_wrap_a_line()
    {
        $maxWidth = (new \League\CLImate\Util\Dimensions())->width();

        $padding = $this->cli->padding();

        $content = str_repeat("a", $maxWidth * 2);
        $content = substr($content, 0, ($maxWidth * 2) - 5);

        $this->shouldWrite(substr($content, 0, $maxWidth));
        $this->shouldWrite(substr($content, $maxWidth) . ".....");
        $padding->pad($content);
    }


    /** @test */

    public function it_can_pad_a_line_inline()
    {
        $padding = $this->cli->padding(10);

        $this->output->shouldReceive("sameLine");
        $this->shouldWrite("Pad me....");
        $padding->inline("Pad me");
    }


    /** @test */

    public function it_can_chain()
    {
        $padding = $this->cli->padding(10);

        $this->output->shouldReceive("sameLine");
        $this->shouldWrite("Pad me....");
        $this->shouldWrite("extra");
        $this->shouldWrite("Pad me....");
        $this->shouldWrite("extra");

        $padding->inline("Pad me")->out("extra")->pad("Pad me")->out("extra");
    }


    /** @test */

    public function it_can_pad_with_multiple_characters()
    {
        $padding = $this->cli->padding(10)->padWith(".-");

        $this->shouldWrite("Pad me.-.-");
        $padding->pad("Pad me");
    }


    /** @test */

    public function it_can_pad_with_multiple_characters_odd()
    {
        $padding = $this->cli->padding(10, ".-");

        $this->shouldWrite("Pad odd-.-");
        $padding->pad("Pad odd");
    }


}
