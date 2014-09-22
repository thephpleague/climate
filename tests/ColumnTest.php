<?php

require_once 'TestBase.php';

class ColumnTest extends TestBase
{

    /** @test */

    public function it_can_output_columns()
    {
        ob_start();

        $this->cli->columns([
                        'this',
                        'that',
                        'other',
                        'thing',
                        'this',
                        'too',
                        'and',
                        'also',
                        'this is much longer',
                    ]);

        $result = ob_get_contents();

        ob_end_clean();

        $should_be = "\e[mthis      thing     and                     \e[0m\n";
        $should_be .= "\e[mthat      this      also                    \e[0m\n";
        $should_be .= "\e[mother     too       this is much longer     \e[0m\n";

        $this->assertSame($should_be, $result);
    }

    /** @test */

    public function it_can_output_a_specific_number_of_columns()
    {
        ob_start();

        $this->cli->columns([
                        'this',
                        'that',
                        'other',
                        'thing',
                        'this',
                        'too',
                        'and',
                        'also',
                        'this is much longer',
                    ], 2);

        $this->cli->columns([
                        'this',
                        'that',
                        'other',
                        'thing',
                        'this',
                        'too',
                        'and',
                        'also',
                        'this is much longer',
                    ], 1);

        $result = ob_get_contents();

        ob_end_clean();

        $should_be = "\e[mthis      too                     \e[0m\n";
        $should_be .= "\e[mthat      and                     \e[0m\n";
        $should_be .= "\e[mother     also                    \e[0m\n";
        $should_be .= "\e[mthing     this is much longer     \e[0m\n";
        $should_be .= "\e[mthis      \e[0m\n";
        $should_be .= "\e[mthis                    \e[0m\n";
        $should_be .= "\e[mthat                    \e[0m\n";
        $should_be .= "\e[mother                   \e[0m\n";
        $should_be .= "\e[mthing                   \e[0m\n";
        $should_be .= "\e[mthis                    \e[0m\n";
        $should_be .= "\e[mtoo                     \e[0m\n";
        $should_be .= "\e[mand                     \e[0m\n";
        $should_be .= "\e[malso                    \e[0m\n";
        $should_be .= "\e[mthis is much longer     \e[0m\n";

        $this->assertSame($should_be, $result);
    }

    /** @test */

    public function it_can_handle_multibyte_strings()
    {
        ob_start();

        $this->cli->columns([
                        'this',
                        'that',
                        'other',
                        'thing',
                        'this',
                        'too',
                        'and',
                        'also',
                        'this is much longeø',
                    ]);

        $result = ob_get_contents();

        ob_end_clean();

        $should_be = "\e[mthis      thing     and                     \e[0m\n";
        $should_be .= "\e[mthat      this      also                    \e[0m\n";
        $should_be .= "\e[mother     too       this is much longeø     \e[0m\n";

        $this->assertSame($should_be, $result);
    }

}
