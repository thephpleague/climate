<?php

require_once 'TestBase.php';

class ProgressTest extends TestBase
{

    /**
     * @param integer $length
     */
    private function repeat($length)
    {
        $repeat = ($length / 100) * 70;
        $bar = str_repeat('=', $repeat);
        $bar .= '>';
        $bar .= str_repeat(' ', max(70 - $repeat, 0));

        return $bar;
    }

    /** @test */

    public function it_can_output_a_progress_bar()
    {
        ob_start();

        $progress = $this->cli->progress()->total(10);

        for ($i = 0; $i <= 10; $i++) {
            $progress->current($i);
        }

        $result = ob_get_contents();

        ob_end_clean();

        $should_be = "\n";
        $should_be .= "\e[m\e[1A\r\e[K{$this->repeat(0)} 0%\e[0m\n";
        $should_be .= "\e[m\e[1A\r\e[K{$this->repeat(10)} 10%\e[0m\n";
        $should_be .= "\e[m\e[1A\r\e[K{$this->repeat(20)} 20%\e[0m\n";
        $should_be .= "\e[m\e[1A\r\e[K{$this->repeat(30)} 30%\e[0m\n";
        $should_be .= "\e[m\e[1A\r\e[K{$this->repeat(40)} 40%\e[0m\n";
        $should_be .= "\e[m\e[1A\r\e[K{$this->repeat(50)} 50%\e[0m\n";
        $should_be .= "\e[m\e[1A\r\e[K{$this->repeat(60)} 60%\e[0m\n";
        $should_be .= "\e[m\e[1A\r\e[K{$this->repeat(70)} 70%\e[0m\n";
        $should_be .= "\e[m\e[1A\r\e[K{$this->repeat(80)} 80%\e[0m\n";
        $should_be .= "\e[m\e[1A\r\e[K{$this->repeat(90)} 90%\e[0m\n";
        $should_be .= "\e[m\e[1A\r\e[K{$this->repeat(100)} 100%\e[0m\n";

        $this->assertSame($should_be, $result);
    }

    /** @test */

    public function it_can_output_a_progress_bar_via_constructor()
    {
        ob_start();

        $progress = $this->cli->progress(10);

        for ($i = 0; $i <= 10; $i++) {
            $progress->current($i);
        }

        $result = ob_get_contents();

        ob_end_clean();

        $should_be = "\n";
        $should_be .= "\e[m\e[1A\r\e[K{$this->repeat(0)} 0%\e[0m\n";
        $should_be .= "\e[m\e[1A\r\e[K{$this->repeat(10)} 10%\e[0m\n";
        $should_be .= "\e[m\e[1A\r\e[K{$this->repeat(20)} 20%\e[0m\n";
        $should_be .= "\e[m\e[1A\r\e[K{$this->repeat(30)} 30%\e[0m\n";
        $should_be .= "\e[m\e[1A\r\e[K{$this->repeat(40)} 40%\e[0m\n";
        $should_be .= "\e[m\e[1A\r\e[K{$this->repeat(50)} 50%\e[0m\n";
        $should_be .= "\e[m\e[1A\r\e[K{$this->repeat(60)} 60%\e[0m\n";
        $should_be .= "\e[m\e[1A\r\e[K{$this->repeat(70)} 70%\e[0m\n";
        $should_be .= "\e[m\e[1A\r\e[K{$this->repeat(80)} 80%\e[0m\n";
        $should_be .= "\e[m\e[1A\r\e[K{$this->repeat(90)} 90%\e[0m\n";
        $should_be .= "\e[m\e[1A\r\e[K{$this->repeat(100)} 100%\e[0m\n";

        $this->assertSame($should_be, $result);
    }

    /** @test */

    public function it_can_output_a_progress_bar_with_current_labels()
    {
        ob_start();

        $progress = $this->cli->progress(10);

        $labels = [
            'zeroth',
            'first',
            'second',
            'third',
            'fourth',
            'fifth',
            'sixth',
            'seventh',
            'eighth',
            'ninth',
            'tenth',
        ];

        for ($i = 0; $i <= 10; $i++) {
            $progress->current($i, $labels[$i]);
        }

        $result = ob_get_contents();

        ob_end_clean();

        $should_be = "\n";
        $should_be .= "\e[m\e[2A\r\e[K{$this->repeat(0)} 0%\nzeroth\e[0m\n";
        $should_be .= "\e[m\e[2A\r\e[K{$this->repeat(10)} 10%\nfirst\e[0m\n";
        $should_be .= "\e[m\e[2A\r\e[K{$this->repeat(20)} 20%\nsecond\e[0m\n";
        $should_be .= "\e[m\e[2A\r\e[K{$this->repeat(30)} 30%\nthird\e[0m\n";
        $should_be .= "\e[m\e[2A\r\e[K{$this->repeat(40)} 40%\nfourth\e[0m\n";
        $should_be .= "\e[m\e[2A\r\e[K{$this->repeat(50)} 50%\nfifth\e[0m\n";
        $should_be .= "\e[m\e[2A\r\e[K{$this->repeat(60)} 60%\nsixth\e[0m\n";
        $should_be .= "\e[m\e[2A\r\e[K{$this->repeat(70)} 70%\nseventh\e[0m\n";
        $should_be .= "\e[m\e[2A\r\e[K{$this->repeat(80)} 80%\neighth\e[0m\n";
        $should_be .= "\e[m\e[2A\r\e[K{$this->repeat(90)} 90%\nninth\e[0m\n";
        $should_be .= "\e[m\e[2A\r\e[K{$this->repeat(100)} 100%\e[0m\n";

        $this->assertSame($should_be, $result);
    }

    /** @test */

    public function it_can_output_a_styled_progress_bar()
    {
        ob_start();

        $progress = $this->cli->redProgress(10);

        for ($i = 0; $i <= 10; $i++) {
            $progress->current($i);
        }

        $result = ob_get_contents();

        ob_end_clean();

        $should_be = "\n";
        $should_be .= "\e[31m\e[1A\r\e[K{$this->repeat(0)} 0%\e[0m\n";
        $should_be .= "\e[31m\e[1A\r\e[K{$this->repeat(10)} 10%\e[0m\n";
        $should_be .= "\e[31m\e[1A\r\e[K{$this->repeat(20)} 20%\e[0m\n";
        $should_be .= "\e[31m\e[1A\r\e[K{$this->repeat(30)} 30%\e[0m\n";
        $should_be .= "\e[31m\e[1A\r\e[K{$this->repeat(40)} 40%\e[0m\n";
        $should_be .= "\e[31m\e[1A\r\e[K{$this->repeat(50)} 50%\e[0m\n";
        $should_be .= "\e[31m\e[1A\r\e[K{$this->repeat(60)} 60%\e[0m\n";
        $should_be .= "\e[31m\e[1A\r\e[K{$this->repeat(70)} 70%\e[0m\n";
        $should_be .= "\e[31m\e[1A\r\e[K{$this->repeat(80)} 80%\e[0m\n";
        $should_be .= "\e[31m\e[1A\r\e[K{$this->repeat(90)} 90%\e[0m\n";
        $should_be .= "\e[31m\e[1A\r\e[K{$this->repeat(100)} 100%\e[0m\n";

        $this->assertSame($should_be, $result);
    }

    /** @test */

    public function it_can_output_a_styled_progress_bar_and_resets_the_style()
    {
        ob_start();

        $progress = $this->cli->redProgress(10);

        for ($i = 0; $i <= 10; $i++) {
            $progress->current($i);
        }

        $this->cli->out('and back to normal');

        $result = ob_get_contents();

        ob_end_clean();

        $should_be = "\n";
        $should_be .= "\e[31m\e[1A\r\e[K{$this->repeat(0)} 0%\e[0m\n";
        $should_be .= "\e[31m\e[1A\r\e[K{$this->repeat(10)} 10%\e[0m\n";
        $should_be .= "\e[31m\e[1A\r\e[K{$this->repeat(20)} 20%\e[0m\n";
        $should_be .= "\e[31m\e[1A\r\e[K{$this->repeat(30)} 30%\e[0m\n";
        $should_be .= "\e[31m\e[1A\r\e[K{$this->repeat(40)} 40%\e[0m\n";
        $should_be .= "\e[31m\e[1A\r\e[K{$this->repeat(50)} 50%\e[0m\n";
        $should_be .= "\e[31m\e[1A\r\e[K{$this->repeat(60)} 60%\e[0m\n";
        $should_be .= "\e[31m\e[1A\r\e[K{$this->repeat(70)} 70%\e[0m\n";
        $should_be .= "\e[31m\e[1A\r\e[K{$this->repeat(80)} 80%\e[0m\n";
        $should_be .= "\e[31m\e[1A\r\e[K{$this->repeat(90)} 90%\e[0m\n";
        $should_be .= "\e[31m\e[1A\r\e[K{$this->repeat(100)} 100%\e[0m\n";
        $should_be .= "\e[mand back to normal\e[0m\n";

        $this->assertSame($should_be, $result);
    }

    /**
     * @test
     * @expectedException        Exception
     * @expectedExceptionMessage The progress total must be greater than zero.
     */

    public function it_can_throws_an_exception_for_a_zero_total_progress_bar()
    {
        $progress = $this->cli->progress();

        for ($i = 0; $i <= 10; $i++) {
            $progress->current($i);
        }
    }

    /**
     * @test
     * @expectedException        Exception
     * @expectedExceptionMessage The current is greater than the total.
     */

    public function it_can_throws_an_exception_when_the_current_is_greater_than_the_total()
    {
        $progress = $this->cli->progress( 1 );

        for ($i = 2; $i <= 10; $i++) {
            $progress->current($i);
        }
    }

}
