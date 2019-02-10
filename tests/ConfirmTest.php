<?php

namespace League\CLImate\Tests;

class ConfirmTest extends TestBase
{
    /** @test */
    public function it_will_return_true_for_y()
    {
        $this->shouldReadAndReturn('y');
        $this->shouldReceiveSameLine();
        $this->shouldWrite("\e[mKeep going? [y/N] \e[0m");

        $input = $this->cli->confirm('Keep going?', $this->reader);

        $response = $input->confirmed();

        $this->assertTrue($response);
    }

    /** @test */
    public function it_will_return_false_for_n()
    {
        $this->shouldReadAndReturn('n');
        $this->shouldReceiveSameLine();
        $this->shouldWrite("\e[mKeep going? [y/N] \e[0m");

        $input = $this->cli->confirm('Keep going?', $this->reader);

        $response = $input->confirmed();

        $this->assertFalse($response);
    }


    /**
     * Ensure that the default (yes) is respected.
     */
    public function testDefaultToYes()
    {
        $this->shouldReadAndReturn("");
        $this->shouldReceiveSameLine();
        $this->shouldWrite("\e[mKeep going? [Y/n] \e[0m");

        $input = $this->cli->confirm("Keep going?", $this->reader);
        $input->defaultTo("y");

        $response = $input->confirmed();

        $this->assertTrue($response);
    }



    /**
     * Ensure that the default (no) is respected.
     */
    public function testDefaultToNo()
    {
        $this->shouldReadAndReturn("");
        $this->shouldReceiveSameLine();
        $this->shouldWrite("\e[mKeep going? [y/N] \e[0m");

        $input = $this->cli->confirm("Keep going?", $this->reader);
        $input->defaultTo("n");

        $response = $input->confirmed();

        $this->assertFalse($response);
    }
}
