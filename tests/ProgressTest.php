<?php

require_once 'TestBase.php';
require_once __DIR__ . '/../src/Util/Dimensions.php';

class ProgressTest extends TestBase
{

    /**
     * The string length of the bar when at 100%
     *
     * @var integer $bar_str_len
     */

    protected $bar_str_len;

    /**
     * @param integer $length
     */
    private function repeat($length)
    {
        if (!$this->bar_str_len) {
            // Subtract 10 because of the '> 100%' plus some padding, max 100
            $this->bar_str_len = min((new \League\CLImate\Util\Dimensions())->width() - 10, 100);
        }

        $repeat = ($length / 100) * $this->bar_str_len;
        $bar = str_repeat('=', $repeat);
        $bar .= '>';
        $bar .= str_repeat(' ', max($this->bar_str_len - $repeat, 0));

        return $bar;
    }

    /** @test */

    public function it_can_output_a_progress_bar()
    {
        $this->shouldWrite('');
        $this->shouldWrite("\e[m\e[1A\r\e[K{$this->repeat(0)} 0%\e[0m");
        $this->shouldWrite("\e[m\e[1A\r\e[K{$this->repeat(10)} 10%\e[0m");
        $this->shouldWrite("\e[m\e[1A\r\e[K{$this->repeat(20)} 20%\e[0m");
        $this->shouldWrite("\e[m\e[1A\r\e[K{$this->repeat(30)} 30%\e[0m");
        $this->shouldWrite("\e[m\e[1A\r\e[K{$this->repeat(40)} 40%\e[0m");
        $this->shouldWrite("\e[m\e[1A\r\e[K{$this->repeat(50)} 50%\e[0m");
        $this->shouldWrite("\e[m\e[1A\r\e[K{$this->repeat(60)} 60%\e[0m");
        $this->shouldWrite("\e[m\e[1A\r\e[K{$this->repeat(70)} 70%\e[0m");
        $this->shouldWrite("\e[m\e[1A\r\e[K{$this->repeat(80)} 80%\e[0m");
        $this->shouldWrite("\e[m\e[1A\r\e[K{$this->repeat(90)} 90%\e[0m");
        $this->shouldWrite("\e[m\e[1A\r\e[K{$this->repeat(100)} 100%\e[0m");

        $progress = $this->cli->progress()->total(10);

        for ($i = 0; $i <= 10; $i++) {
            $progress->current($i);
        }
    }

    /** @test */

    public function it_can_output_a_progress_bar_via_constructor()
    {
        $this->shouldWrite('');
        $this->shouldWrite("\e[m\e[1A\r\e[K{$this->repeat(0)} 0%\e[0m");
        $this->shouldWrite("\e[m\e[1A\r\e[K{$this->repeat(10)} 10%\e[0m");
        $this->shouldWrite("\e[m\e[1A\r\e[K{$this->repeat(20)} 20%\e[0m");
        $this->shouldWrite("\e[m\e[1A\r\e[K{$this->repeat(30)} 30%\e[0m");
        $this->shouldWrite("\e[m\e[1A\r\e[K{$this->repeat(40)} 40%\e[0m");
        $this->shouldWrite("\e[m\e[1A\r\e[K{$this->repeat(50)} 50%\e[0m");
        $this->shouldWrite("\e[m\e[1A\r\e[K{$this->repeat(60)} 60%\e[0m");
        $this->shouldWrite("\e[m\e[1A\r\e[K{$this->repeat(70)} 70%\e[0m");
        $this->shouldWrite("\e[m\e[1A\r\e[K{$this->repeat(80)} 80%\e[0m");
        $this->shouldWrite("\e[m\e[1A\r\e[K{$this->repeat(90)} 90%\e[0m");
        $this->shouldWrite("\e[m\e[1A\r\e[K{$this->repeat(100)} 100%\e[0m");

        $progress = $this->cli->progress(10);

        for ($i = 0; $i <= 10; $i++) {
            $progress->current($i);
        }
    }

    /** @test */

    public function it_can_output_a_progress_bar_with_current_labels()
    {
        $this->shouldWrite('');
        $this->shouldWrite("\e[m\e[2A\r\e[K{$this->repeat(0)} 0%\n\r\e[Kzeroth\e[0m");
        $this->shouldWrite("\e[m\e[2A\r\e[K{$this->repeat(10)} 10%\n\r\e[Kfirst\e[0m");
        $this->shouldWrite("\e[m\e[2A\r\e[K{$this->repeat(20)} 20%\n\r\e[Ksecond\e[0m");
        $this->shouldWrite("\e[m\e[2A\r\e[K{$this->repeat(30)} 30%\n\r\e[Kthird\e[0m");
        $this->shouldWrite("\e[m\e[2A\r\e[K{$this->repeat(40)} 40%\n\r\e[Kfourth\e[0m");
        $this->shouldWrite("\e[m\e[2A\r\e[K{$this->repeat(50)} 50%\n\r\e[Kfifth\e[0m");
        $this->shouldWrite("\e[m\e[2A\r\e[K{$this->repeat(60)} 60%\n\r\e[Ksixth\e[0m");
        $this->shouldWrite("\e[m\e[2A\r\e[K{$this->repeat(70)} 70%\n\r\e[Kseventh\e[0m");
        $this->shouldWrite("\e[m\e[2A\r\e[K{$this->repeat(80)} 80%\n\r\e[Keighth\e[0m");
        $this->shouldWrite("\e[m\e[2A\r\e[K{$this->repeat(90)} 90%\n\r\e[Kninth\e[0m");
        $this->shouldWrite("\e[m\e[2A\r\e[K{$this->repeat(100)} 100%\e[0m");

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
    }

    /** @test */

    public function it_can_output_a_styled_progress_bar()
    {
        $this->shouldWrite('');
        $this->shouldWrite("\e[31m\e[1A\r\e[K{$this->repeat(0)} 0%\e[0m");
        $this->shouldWrite("\e[31m\e[1A\r\e[K{$this->repeat(10)} 10%\e[0m");
        $this->shouldWrite("\e[31m\e[1A\r\e[K{$this->repeat(20)} 20%\e[0m");
        $this->shouldWrite("\e[31m\e[1A\r\e[K{$this->repeat(30)} 30%\e[0m");
        $this->shouldWrite("\e[31m\e[1A\r\e[K{$this->repeat(40)} 40%\e[0m");
        $this->shouldWrite("\e[31m\e[1A\r\e[K{$this->repeat(50)} 50%\e[0m");
        $this->shouldWrite("\e[31m\e[1A\r\e[K{$this->repeat(60)} 60%\e[0m");
        $this->shouldWrite("\e[31m\e[1A\r\e[K{$this->repeat(70)} 70%\e[0m");
        $this->shouldWrite("\e[31m\e[1A\r\e[K{$this->repeat(80)} 80%\e[0m");
        $this->shouldWrite("\e[31m\e[1A\r\e[K{$this->repeat(90)} 90%\e[0m");
        $this->shouldWrite("\e[31m\e[1A\r\e[K{$this->repeat(100)} 100%\e[0m");

        $progress = $this->cli->redProgress(10);

        for ($i = 0; $i <= 10; $i++) {
            $progress->current($i);
        }
    }

    /** @test */

    public function it_can_output_a_styled_progress_bar_and_resets_the_style()
    {
        $this->shouldWrite('');
        $this->shouldWrite("\e[31m\e[1A\r\e[K{$this->repeat(0)} 0%\e[0m");
        $this->shouldWrite("\e[31m\e[1A\r\e[K{$this->repeat(10)} 10%\e[0m");
        $this->shouldWrite("\e[31m\e[1A\r\e[K{$this->repeat(20)} 20%\e[0m");
        $this->shouldWrite("\e[31m\e[1A\r\e[K{$this->repeat(30)} 30%\e[0m");
        $this->shouldWrite("\e[31m\e[1A\r\e[K{$this->repeat(40)} 40%\e[0m");
        $this->shouldWrite("\e[31m\e[1A\r\e[K{$this->repeat(50)} 50%\e[0m");
        $this->shouldWrite("\e[31m\e[1A\r\e[K{$this->repeat(60)} 60%\e[0m");
        $this->shouldWrite("\e[31m\e[1A\r\e[K{$this->repeat(70)} 70%\e[0m");
        $this->shouldWrite("\e[31m\e[1A\r\e[K{$this->repeat(80)} 80%\e[0m");
        $this->shouldWrite("\e[31m\e[1A\r\e[K{$this->repeat(90)} 90%\e[0m");
        $this->shouldWrite("\e[31m\e[1A\r\e[K{$this->repeat(100)} 100%\e[0m");
        $this->shouldWrite("\e[mand back to normal\e[0m");

        $progress = $this->cli->redProgress(10);

        for ($i = 0; $i <= 10; $i++) {
            $progress->current($i);
        }

        $this->cli->out('and back to normal');
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
