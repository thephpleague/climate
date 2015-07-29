<?php

namespace League\CLImate\Tests;

class ConfirmTest extends TestBase
{

    /** @test */
    public function it_will_return_true_for_y()
    {
        $this->shouldReadAndReturn('y');
        $this->shouldReceiveSameLine();
        $this->shouldWrite("\e[mKeep going? [y/n] \e[0m");

        $input = $this->cli->confirm('Keep going?', $this->reader);

        $response = $input->confirmed();

        $this->assertTrue($response);
    }

    /** @test */
    public function it_will_return_false_for_n()
    {
        $this->shouldReadAndReturn('n');
        $this->shouldReceiveSameLine();
        $this->shouldWrite("\e[mKeep going? [y/n] \e[0m");

        $input = $this->cli->confirm('Keep going?', $this->reader);

        $response = $input->confirmed();

        $this->assertFalse($response);
    }

    /** @test */
    public function it_will_only_allow_strict_confirmations()
    {
        $this->shouldReadAndReturn('Y');
        $this->shouldReadAndReturn('y');
        $this->shouldReceiveSameLine();
        $this->shouldWrite("\e[mKeep going? [y/n] \e[0m", 2);

        $input = $this->cli->confirm('Keep going?', $this->reader);

        $input->confirmed();
    }

}
