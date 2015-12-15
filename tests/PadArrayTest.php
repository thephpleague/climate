<?php

namespace League\CLImate\Tests;

class PadArrayTest extends TestBase
{

    /** @test */
    public function it_can_pad_with_multiple_characters()
    {
        $padding = $this->cli->padArray([
            "field-name-1"  =>  "one",
            "field-name-2"  =>  "two",
        ]);

        $this->output->shouldReceive('sameLine');
        $this->shouldWrite('Pad me.-.-');
        $this->shouldWrite(' extra');

        $padding->label('Pad me')->result('extra');
    }
}
