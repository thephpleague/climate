<?php

namespace League\CLImate\Tests;

class ColumnTest extends TestBase
{
    protected function getStandardColumns()
    {
        return [
            'this',
            'that',
            'other',
            'thing',
            'this',
            'too',
            'and',
            'also',
            'this is much longer',
        ];
    }

    protected function getArrayOfArrayColumns()
    {
        return [
            ['one', 'first one', 'first third column'],
            ['two', 'second one', 'second third column'],
            ['three', 'third one', 'third third column'],
            ['four', 'fourth one', 'fourth third column'],
            ['five', 'fifth one', 'fifth third column'],
        ];
    }

    protected function getAssociativeColumns()
    {
        return [
            'one'   => 'first one',
            'two'   => 'second one',
            'three' => 'third one',
            'four'  => 'fourth one',
            'five'  => 'fifth one',
        ];
    }

    /** @test */
    public function it_can_output_columns()
    {
        $this->shouldWrite("\e[mthis      thing     and\e[0m");
        $this->shouldWrite("\e[mthat      this      also\e[0m");
        $this->shouldWrite("\e[mother     too       this is much longer\e[0m");
        $this->shouldHavePersisted();

        $this->cli->columns($this->getStandardColumns());
    }

    /** @test */
    public function it_can_output_a_specific_number_of_columns()
    {
        $this->shouldWrite("\e[mthis      too\e[0m");
        $this->shouldWrite("\e[mthat      and\e[0m");
        $this->shouldWrite("\e[mother     also\e[0m");
        $this->shouldWrite("\e[mthing     this is much longer\e[0m");
        $this->shouldWrite("\e[mthis\e[0m");
        $this->shouldWrite("\e[mthis\e[0m");
        $this->shouldWrite("\e[mthat\e[0m");
        $this->shouldWrite("\e[mother\e[0m");
        $this->shouldWrite("\e[mthing\e[0m");
        $this->shouldWrite("\e[mthis\e[0m");
        $this->shouldWrite("\e[mtoo\e[0m");
        $this->shouldWrite("\e[mand\e[0m");
        $this->shouldWrite("\e[malso\e[0m");
        $this->shouldWrite("\e[mthis is much longer\e[0m");
        $this->shouldHavePersisted(2);

        $this->cli->columns($this->getStandardColumns(), 2);

        $this->cli->columns($this->getStandardColumns(), 1);
    }

    /** @test */
    public function it_can_handle_multibyte_strings()
    {
        $this->shouldWrite("\e[mthis      thing     and\e[0m");
        $this->shouldWrite("\e[mthat      this      also\e[0m");
        $this->shouldWrite("\e[mother     too       this is much longerø\e[0m");
        $this->shouldHavePersisted();

        $columns    = $this->getStandardColumns();
        $columns[8] = $columns[8] . 'ø';

        $this->cli->columns($columns);
    }

    /** @test */
    public function it_can_output_an_associative_array_as_columns()
    {
        $this->shouldWrite("\e[mone       first one\e[0m");
        $this->shouldWrite("\e[mtwo       second one\e[0m");
        $this->shouldWrite("\e[mthree     third one\e[0m");
        $this->shouldWrite("\e[mfour      fourth one\e[0m");
        $this->shouldWrite("\e[mfive      fifth one\e[0m");
        $this->shouldHavePersisted();

        $this->cli->columns($this->getAssociativeColumns());
    }

    /** @test */
    public function it_can_output_an_array_of_arrays_as_columns()
    {
        $this->shouldWrite("\e[mone       first one      first third column\e[0m");
        $this->shouldWrite("\e[mtwo       second one     second third column\e[0m");
        $this->shouldWrite("\e[mthree     third one      third third column\e[0m");
        $this->shouldWrite("\e[mfour      fourth one     fourth third column\e[0m");
        $this->shouldWrite("\e[mfive      fifth one      fifth third column\e[0m");
        $this->shouldHavePersisted();

        $this->cli->columns($this->getArrayOfArrayColumns());
    }

    /** @test */
    public function it_can_output_an_uneven_array_of_arrays_as_columns()
    {
        $this->shouldWrite("\e[mone       first one      first third column\e[0m");
        $this->shouldWrite("\e[mtwo       second one     second third column\e[0m");
        $this->shouldWrite("\e[mthree     third one      third third column\e[0m");
        $this->shouldWrite("\e[mfour      fourth one     fourth third column     also this one\e[0m");
        $this->shouldWrite("\e[mfive      fifth one      fifth third column\e[0m");
        $this->shouldHavePersisted();

        $columns = $this->getArrayOfArrayColumns();
        $columns[3][] = 'also this one';

        $this->cli->columns($columns);
    }

}
