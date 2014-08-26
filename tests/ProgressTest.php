<?php

class ProgressTest extends PHPUnit_Framework_TestCase
{
    public $cli;

    public function setUp()
    {
        $this->cli = new JoeTannenbaum\CLImate\CLImate;
    }

    private function repeat( $length )
    {
        return str_repeat( '=', $length );
    }

    /** @test */

    // public function it_can_output_a_progress_bar()
    // {
    //     ob_start();

    //     $progress = $this->cli->progress()->total(10);

    //     for ( $i = 0; $i <= 10; $i++ )
    //     {
    //         $progress->current( $i );
    //     }

    //     $result = ob_get_contents();

    //     ob_end_clean();

    //     $should_be = "\r\e[K> 0%";
    //     $should_be .= "\r\e[K==========> 10%";
    //     $should_be .= "\r\e[K====================> 20%";
    //     $should_be .= "\r\e[K==============================> 30%";
    //     $should_be .= "\r\e[K========================================> 40%";
    //     $should_be .= "\r\e[K==================================================> 50%";
    //     $should_be .= "\r\e[K============================================================> 60%";
    //     $should_be .= "\r\e[K======================================================================> 70%";
    //     $should_be .= "\r\e[K================================================================================> 80%";
    //     $should_be .= "\r\e[K==========================================================================================> 90%";
    //     $should_be .= "\r\e[K====================================================================================================> 100%";
    //     $should_be .= "\n";

    //     $this->assertSame( $should_be, $result );
    // }

    /** @test */

    public function it_can_output_a_progress_bar_via_constructor()
    {
        ob_start();

        $progress = $this->cli->progress(10);

        for ( $i = 0; $i <= 10; $i++ )
        {
            $progress->current( $i );
        }


        $result = ob_get_contents();

        ob_end_clean();

        $should_be = "\n";
        $should_be .= "\e[m\e[1A\r\e[K> 0%\e[0m\n";
        $should_be .= "\e[m\e[1A\r\e[K{$this->repeat(10)}> 10%\e[0m\n";
        $should_be .= "\e[m\e[1A\r\e[K{$this->repeat(20)}> 20%\e[0m\n";
        $should_be .= "\e[m\e[1A\r\e[K{$this->repeat(30)}> 30%\e[0m\n";
        $should_be .= "\e[m\e[1A\r\e[K{$this->repeat(40)}> 40%\e[0m\n";
        $should_be .= "\e[m\e[1A\r\e[K{$this->repeat(50)}> 50%\e[0m\n";
        $should_be .= "\e[m\e[1A\r\e[K{$this->repeat(60)}> 60%\e[0m\n";
        $should_be .= "\e[m\e[1A\r\e[K{$this->repeat(70)}> 70%\e[0m\n";
        $should_be .= "\e[m\e[1A\r\e[K{$this->repeat(80)}> 80%\e[0m\n";
        $should_be .= "\e[m\e[1A\r\e[K{$this->repeat(90)}> 90%\e[0m\n";
        $should_be .= "\e[m\e[1A\r\e[K{$this->repeat(100)}> 100%\e[0m\n";

        $this->assertSame( $should_be, $result );
    }

    /** @test */

    // public function it_can_output_a_styled_progress_bar()
    // {
    //     ob_start();

    //     $progress = $this->cli->redProgress(10);

    //     for ( $i = 0; $i <= 10; $i++ )
    //     {
    //         $progress->current( $i );
    //     }

    //     $result = ob_get_contents();

    //     ob_end_clean();

    //     $should_be = "\e[31m\r\e[K> 0%\e[0m\n";
    //     $should_be .= "\e[31m\r\e[K==========> 10%\e[0m\n";
    //     $should_be .= "\e[31m\r\e[K====================> 20%\e[0m\n";
    //     $should_be .= "\e[31m\r\e[K==============================> 30%\e[0m\n";
    //     $should_be .= "\e[31m\r\e[K========================================> 40%\e[0m\n";
    //     $should_be .= "\e[31m\r\e[K==================================================> 50%\e[0m\n";
    //     $should_be .= "\e[31m\r\e[K============================================================> 60%\e[0m\n";
    //     $should_be .= "\e[31m\r\e[K======================================================================> 70%\e[0m\n";
    //     $should_be .= "\e[31m\r\e[K================================================================================> 80%\e[0m\n";
    //     $should_be .= "\e[31m\r\e[K==========================================================================================> 90%\e[0m\n";
    //     $should_be .= "\e[31m\r\e[K====================================================================================================> 100%\e[0m\n";

    //     $this->assertSame( $should_be, $result );
    // }

    /**
     * @test
     * @expectedException        Exception
     * @expectedExceptionMessage The progress total must be greater than zero.
     */

    public function it_can_throws_an_exception_for_a_zero_total_progress_bar()
    {
        $progress = $this->cli->progress();

        for ( $i = 0; $i <= 10; $i++ )
        {
            $progress->current( $i );
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

        for ( $i = 2; $i <= 10; $i++ )
        {
            $progress->current( $i );
        }
    }

}