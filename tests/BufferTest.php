<?php

namespace League\CLImate\Tests;

use League\CLImate\Util\Output;
use League\CLImate\Util\Writer\Buffer;

class BufferTest extends TestBase
{

    /** @test */
    public function it_can_buffer_content()
    {
        $buffer = new Buffer;
        $output = new Output;
        $output->add('buffer', $buffer);
        $output->defaultTo('buffer');

        $output->write("Oh, you're still here.");

        $this->assertSame("Oh, you're still here.\n", $buffer->get());
    }

    /** @test */
    public function it_can_buffer_content_without_a_new_line()
    {
        $buffer = new Buffer;
        $output = new Output;
        $output->add('buffer', $buffer);
        $output->defaultTo('buffer');

        $output->sameLine()->write("Oh, you're still here.");

        $this->assertSame("Oh, you're still here.", $buffer->get());
    }

    /** @test */
    public function it_can_buffer_multiple_lines()
    {
        $buffer = new Buffer;
        $output = new Output;
        $output->add('buffer', $buffer);
        $output->defaultTo('buffer');

        $output->write("Oh, you're still here.");
        $output->write("Also am I.");

        $this->assertSame("Oh, you're still here.\nAlso am I.\n", $buffer->get());
    }

    /** @test */
    public function it_can_clean_buffered_content()
    {
        $buffer = new Buffer;
        $output = new Output;
        $output->add('buffer', $buffer);
        $output->defaultTo('buffer');

        $output->write("Oh, you're still here.");
        $buffer->clean();
        $output->write("I am on my own.");

        $this->assertSame("I am on my own.\n", $buffer->get());
    }
}
