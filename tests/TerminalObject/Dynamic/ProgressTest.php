<?php

namespace League\CLImate\Tests\TerminalObject\Dynamic;

use League\CLImate\Tests\TestBase;
use League\CLImate\Exceptions\UnexpectedValueException;

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
     * @return string
     */
    private function repeat($length)
    {
        if (!$this->bar_str_len) {
            // Subtract 10 because of the '> 100%' plus some padding, max 100
            $this->bar_str_len = min($this->util->width() - 10, 100);
        }

        $repeat = ($length / 100) * $this->bar_str_len;
        $bar = str_repeat('=', $repeat);
        $bar .= '>';
        $bar .= str_repeat(' ', max($this->bar_str_len - $repeat, 0));

        return $bar;
    }

    /**
     * @test
     * @doesNotPerformAssertions
     */
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

    /**
     * @test
     * @doesNotPerformAssertions
     */
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

    /**
     * @test
     * @doesNotPerformAssertions
     */
    public function it_can_output_a_progress_bar_with_precision()
    {
        $this->shouldWrite('');
        $this->shouldWrite("\e[m\e[1A\r\e[K{$this->repeat(0)} 0.008%\e[0m");
        $progress = $this->cli->progress(100000);
        $progress->precision(3);
        $progress->current(8);
    }

    /**
     * @test
     * @doesNotPerformAssertions
     */
    public function it_can_output_a_progress_bar_with_precision_rounded()
    {
        $this->shouldWrite('');
        $this->shouldWrite("\e[m\e[1A\r\e[K{$this->repeat(0)} 0.01%\e[0m");
        $progress = $this->cli->progress(100000);
        $progress->precision(2);
        $progress->current(8);
    }

    /**
     * @test
     * @doesNotPerformAssertions
     */
    public function it_can_output_a_progress_bar_with_current_labels()
    {
        $this->shouldWrite('');
        $this->shouldWrite("\e[m\e[1A\r\e[K{$this->repeat(0)} 0%\n\r\e[Kzeroth\e[0m");
        $this->shouldWrite("\e[m\e[2A\r\e[K{$this->repeat(10)} 10%\n\r\e[Kfirst\e[0m");
        $this->shouldWrite("\e[m\e[2A\r\e[K{$this->repeat(20)} 20%\n\r\e[Ksecond\e[0m");
        $this->shouldWrite("\e[m\e[2A\r\e[K{$this->repeat(30)} 30%\n\r\e[Kthird\e[0m");
        $this->shouldWrite("\e[m\e[2A\r\e[K{$this->repeat(40)} 40%\n\r\e[Kfourth\e[0m");
        $this->shouldWrite("\e[m\e[2A\r\e[K{$this->repeat(50)} 50%\n\r\e[Kfifth\e[0m");
        $this->shouldWrite("\e[m\e[2A\r\e[K{$this->repeat(60)} 60%\n\r\e[Ksixth\e[0m");
        $this->shouldWrite("\e[m\e[2A\r\e[K{$this->repeat(70)} 70%\n\r\e[Kseventh\e[0m");
        $this->shouldWrite("\e[m\e[2A\r\e[K{$this->repeat(80)} 80%\n\r\e[Keighth\e[0m");
        $this->shouldWrite("\e[m\e[2A\r\e[K{$this->repeat(90)} 90%\n\r\e[Kninth\e[0m");
        $this->shouldWrite("\e[m\e[2A\r\e[K{$this->repeat(100)} 100%\n\r\e[Ktenth\e[0m");

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

    /**
     * @test
     * @doesNotPerformAssertions
     */
    public function it_can_output_a_progress_bar_with_current_optional_labels()
    {
        $this->shouldWrite('');
        $this->shouldWrite("\e[m\e[1A\r\e[K{$this->repeat(0)} 0%\n\r\e[Kzeroth\e[0m");
        $this->shouldWrite("\e[m\e[2A\r\e[K{$this->repeat(10)} 10%\n\r\e[K\e[0m");
        $this->shouldWrite("\e[m\e[2A\r\e[K{$this->repeat(20)} 20%\n\r\e[Ksecond\e[0m");
        $this->shouldWrite("\e[m\e[2A\r\e[K{$this->repeat(30)} 30%\n\r\e[Kthird\e[0m");

        $progress = $this->cli->progress(10);

        $labels = [
            'zeroth',
            '',
            'second',
            'third',
        ];

        for ($i = 0; $i <= 3; $i++) {
            $progress->current($i, $labels[$i]);
        }
    }

    /**
     * @test
     * @doesNotPerformAssertions
     */
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

    /**
     * @test
     * @doesNotPerformAssertions
     */
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

        $this->shouldHavePersisted();

        $progress = $this->cli->redProgress(10);

        for ($i = 0; $i <= 10; $i++) {
            $progress->current($i);
        }

        $this->cli->out('and back to normal');
    }

    /**
     * @test
     */
    public function it_can_throws_an_exception_for_a_zero_total_progress_bar()
    {
        $this->expectException(UnexpectedValueException::class);
        $this->expectExceptionMessage("The progress total must be greater than zero.");

        $progress = $this->cli->progress();
        $progress->current(0);
    }

    /**
     * @test
     */
    public function it_can_throws_an_exception_when_the_current_is_greater_than_the_total()
    {
        $this->expectException(UnexpectedValueException::class);
        $this->expectExceptionMessage("The current is greater than the total.");

        $progress = $this->cli->progress(1);
        $progress->current(2);
    }

    /**
     * @test
     * @doesNotPerformAssertions
     */
    public function it_can_output_a_progress_bar_using_increments()
    {
        $this->shouldWrite('');
        $this->shouldWrite("\e[m\e[1A\r\e[K{$this->repeat(10)} 10%\e[0m");
        $this->shouldWrite("\e[m\e[1A\r\e[K{$this->repeat(20)} 20%\e[0m");
        $this->shouldWrite("\e[m\e[1A\r\e[K{$this->repeat(70)} 70%\e[0m");
        $this->shouldWrite("\e[m\e[1A\r\e[K{$this->repeat(50)} 50%\e[0m");
        $this->shouldWrite("\e[m\e[1A\r\e[K{$this->repeat(100)} 100%\e[0m");

        $progress = $this->cli->progress()->total(10);
        $progress->advance();
        $progress->advance(1);
        $progress->advance(5);
        $progress->advance(-2);
        $progress->advance(5);
    }


    /**
     * @test
     * @doesNotPerformAssertions
     */
    public function it_can_output_a_progress_bar_using_increments_with_label()
    {
        $this->shouldWrite('');
        $this->shouldWrite("\e[m\e[1A\r\e[K{$this->repeat(10)} 10%\n\r\e[Kstart\e[0m");
        $this->shouldWrite("\e[m\e[2A\r\e[K{$this->repeat(20)} 20%\n\r\e[Knext\e[0m");
        $this->shouldWrite("\e[m\e[2A\r\e[K{$this->repeat(100)} 100%\n\r\e[Kfinal\e[0m");

        $progress = $this->cli->progress()->total(10);
        $progress->advance(1, 'start');
        $progress->advance(1, 'next');
        $progress->advance(8, 'final');
    }

    /**
     * @test
     * @doesNotPerformAssertions
     */
    public function it_will_force_a_redraw_if_specified()
    {
        $this->shouldWrite('');
        $this->shouldWrite("\e[m\e[1A\r\e[K{$this->repeat(20)} 20%\e[0m");
        $this->shouldWrite("\e[m\e[1A\r\e[K{$this->repeat(40)} 40%\e[0m");
        $this->shouldWrite("\e[m\e[1A\r\e[K{$this->repeat(40)} 40%\e[0m");
        $this->shouldWrite("\e[m\e[1A\r\e[K{$this->repeat(60)} 60%\e[0m");
        $this->shouldWrite("\e[m\e[1A\r\e[K{$this->repeat(80)} 80%\e[0m");
        $this->shouldWrite("\e[m\e[1A\r\e[K{$this->repeat(100)} 100%\e[0m");

        $progress = $this->cli->progress()->total(5);

        $progress->forceRedraw();

        $items = [1, 2, 2, 3, 4, 5];

        foreach ($items as $item) {
            $progress->current($item);
        }
    }

    /**
     * @test
     * @doesNotPerformAssertions
     */
    public function it_will_not_force_a_redraw_if_disabled()
    {
        $this->shouldWrite('');
        $this->shouldWrite("\e[m\e[1A\r\e[K{$this->repeat(20)} 20%\e[0m");
        $this->shouldWrite("\e[m\e[1A\r\e[K{$this->repeat(40)} 40%\e[0m");
        $this->shouldWrite("\e[m\e[1A\r\e[K{$this->repeat(60)} 60%\e[0m");
        $this->shouldWrite("\e[m\e[1A\r\e[K{$this->repeat(80)} 80%\e[0m");
        $this->shouldWrite("\e[m\e[1A\r\e[K{$this->repeat(100)} 100%\e[0m");

        $progress = $this->cli->progress()->total(5);

        $progress->forceRedraw(false);

        $items = [1, 2, 2, 3, 4, 5];

        foreach ($items as $item) {
            $progress->current($item);
        }
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testEach1()
    {
        $this->shouldWrite('');
        $this->shouldWrite("\e[m\e[1A\r\e[K{$this->repeat(50)} 50%\e[0m");
        $this->shouldWrite("\e[m\e[1A\r\e[K{$this->repeat(100)} 100%\e[0m");

        $this->cli->progress()->each([1, 2]);
    }
    public function testEach2()
    {
        $this->shouldWrite('');
        $this->shouldWrite("\e[m\e[1A\r\e[K{$this->repeat(50)} 50%\e[0m");
        $this->shouldWrite("\e[m\e[1A\r\e[K{$this->repeat(100)} 100%\e[0m");

        $items = [];

        $this->cli->progress()->each(["two", "one"], function ($item) use (&$items) {
            $items[] = $item;
        });

        $this->assertSame(["two", "one"], $items);
    }
    public function testEach3()
    {
        $this->shouldWrite('');
        $this->shouldWrite("\e[m\e[1A\r\e[K{$this->repeat(50)} 50%\e[0m");
        $this->shouldWrite("\e[m\e[1A\r\e[K{$this->repeat(100)} 100%\e[0m");

        $items = [];

        $this->cli->progress()->each(["key2" => "two", "key1" => "one"], function ($item, $key) use (&$items) {
            $items[$key] = $item;
        });

        $this->assertSame(["key2" => "two", "key1" => "one"], $items);
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testEach4()
    {
        $this->shouldWrite('');
        $this->shouldWrite("\e[m\e[1A\r\e[K{$this->repeat(20)} 20%\n\r\e[Kone\e[0m");
        $this->shouldWrite("\e[m\e[2A\r\e[K{$this->repeat(40)} 40%\n\r\e[Ktwo\e[0m");
        $this->shouldWrite("\e[m\e[2A\r\e[K{$this->repeat(60)} 60%\n\r\e[Kthree\e[0m");
        $this->shouldWrite("\e[m\e[2A\r\e[K{$this->repeat(80)} 80%\n\r\e[Kfour\e[0m");
        $this->shouldWrite("\e[m\e[2A\r\e[K{$this->repeat(100)} 100%\n\r\e[Kfive\e[0m");

        $this->cli->progress()->each(["one", "two", "three", "four", "five"], function ($item) {
            return $item;
        });
    }
}
