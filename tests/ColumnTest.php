<?php

require_once 'TestBase.php';

class ColumnTest extends TestBase
{

    /** @test */

    public function it_can_output_columns()
    {
        $this->shouldWrite("\e[mthis      thing     and                     \e[0m");
        $this->shouldWrite("\e[mthat      this      also                    \e[0m");
        $this->shouldWrite("\e[mother     too       this is much longer     \e[0m");

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
    }

    /** @test */

    public function it_can_output_a_specific_number_of_columns()
    {
        $this->shouldWrite("\e[mthis      too                     \e[0m");
        $this->shouldWrite("\e[mthat      and                     \e[0m");
        $this->shouldWrite("\e[mother     also                    \e[0m");
        $this->shouldWrite("\e[mthing     this is much longer     \e[0m");
        $this->shouldWrite("\e[mthis      \e[0m");
        $this->shouldWrite("\e[mthis                    \e[0m");
        $this->shouldWrite("\e[mthat                    \e[0m");
        $this->shouldWrite("\e[mother                   \e[0m");
        $this->shouldWrite("\e[mthing                   \e[0m");
        $this->shouldWrite("\e[mthis                    \e[0m");
        $this->shouldWrite("\e[mtoo                     \e[0m");
        $this->shouldWrite("\e[mand                     \e[0m");
        $this->shouldWrite("\e[malso                    \e[0m");
        $this->shouldWrite("\e[mthis is much longer     \e[0m");

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
    }

    /** @test */

    public function it_can_handle_multibyte_strings()
    {
        $this->shouldWrite("\e[mthis      thing     and                     \e[0m");
        $this->shouldWrite("\e[mthat      this      also                    \e[0m");
        $this->shouldWrite("\e[mother     too       this is much longeø     \e[0m");

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
    }

}
