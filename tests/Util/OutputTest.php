<?php

namespace League\CLImate\Tests\Util;

use League\CLImate\Exceptions\InvalidArgumentException;
use League\CLImate\Tests\TestBase;
use League\CLImate\Util\Output;
use League\CLImate\Util\Writer\Buffer;
use League\CLImate\Util\Writer\StdErr;
use League\CLImate\Util\Writer\StdOut;
use Mockery;

use function get_class;

class OutputTest extends TestBase
{
    /**
     * @test
     * @doesNotPerformAssertions
     */
    public function it_can_output_content()
    {
        $out = Mockery::mock(StdOut::class);
        $out->shouldReceive('write')->once()->with("Oh, hey there." . \PHP_EOL);

        $output = new Output();
        $output->add('out', $out);
        $output->defaultTo('out');

        $output->write('Oh, hey there.');
    }

    /**
     * @test
     * @doesNotPerformAssertions
     */
    public function it_can_output_content_without_a_new_line()
    {
        $out = Mockery::mock(StdOut::class);
        $out->shouldReceive('write')->once()->with("Oh, hey there.");

        $output = new Output();
        $output->add('out', $out);
        $output->defaultTo('out');

        $output->sameLine()->write('Oh, hey there.');
    }

    /**
     * @test
     * @doesNotPerformAssertions
     */
    public function it_can_default_to_a_writer()
    {
        $error = Mockery::mock(StdErr::class);
        $error->shouldReceive('write')->once()->with("Oh, hey there.");

        $output = new Output();

        $output->add('error', $error);
        $output->defaultTo('error');

        $output->sameLine()->write('Oh, hey there.');
    }

    /**
     * @test
     * @doesNotPerformAssertions
     */
    public function it_can_default_to_multiple_writers()
    {
        $out = Mockery::mock(StdOut::class);
        $out->shouldReceive('write')->once()->with("Oh, hey there.");

        $error = Mockery::mock(StdErr::class);
        $error->shouldReceive('write')->once()->with("Oh, hey there.");

        $output = new Output();

        $output->add('out', $out);
        $output->add('error', $error);
        $output->defaultTo(['out', 'error']);

        $output->sameLine()->write('Oh, hey there.');
    }

    /**
     * @test
     * @doesNotPerformAssertions
     */
    public function it_can_add_a_default()
    {
        $out = Mockery::mock(StdOut::class);
        $out->shouldReceive('write')->once()->with("Oh, hey there.");

        $error = Mockery::mock(StdErr::class);
        $error->shouldReceive('write')->once()->with("Oh, hey there.");

        $output = new Output();

        $output->add('out', $out);
        $output->add('error', $error);
        $output->defaultTo('out');
        $output->addDefault('error');

        $output->sameLine()->write('Oh, hey there.');
    }

    /**
     * @test
     * @doesNotPerformAssertions
     */
    public function it_can_handle_multiple_writers_for_one_key()
    {
        $out = Mockery::mock(StdOut::class);
        $out->shouldReceive('write')->once()->with('Oh, hey there.');

        $error = Mockery::mock(StdErr::class);
        $error->shouldReceive('write')->once()->with('Oh, hey there.');

        $output = new Output();

        $output->add('combo', [$out, $error]);
        $output->defaultTo('combo');

        $output->sameLine()->write('Oh, hey there.');
    }

    /**
     * @test
     * @doesNotPerformAssertions
     */
    public function it_can_take_existing_writer_keys_and_resolve_them()
    {
        $out = Mockery::mock(StdOut::class);
        $out->shouldReceive('write')->once()->with('Oh, hey there.');

        $error = Mockery::mock(StdErr::class);
        $error->shouldReceive('write')->once()->with('Oh, hey there.');

        $output = new Output();

        $output->add('out', $out);
        $output->add('error', $error);
        $output->add('combo', ['out', 'error']);
        $output->defaultTo('combo');

        $output->sameLine()->write('Oh, hey there.');
    }

    /** @test */
    public function it_can_get_the_available_writers()
    {
        $out    = Mockery::mock(StdOut::class);
        $error  = Mockery::mock(StdErr::class);
        $buffer = Mockery::mock(Buffer::class);

        $output = new Output();

        $output->add('out', $out);
        $output->add('error', $error);
        $output->add('buffer', $buffer);
        $output->add('combo', [$out, $buffer]);
        $output->add('key-combo', ['out', 'error']);
        $output->add('mixed-combo', ['out', $error]);

        $available = [
            'out'    => get_class($out),
            'error'  => get_class($error),
            'buffer' => get_class($buffer),
            'combo'  => [
                get_class($out),
                get_class($buffer),
            ],
            'key-combo' => [
                get_class($out),
                get_class($error),
            ],
            'mixed-combo' => [
                get_class($out),
                get_class($error),
            ],
        ];

        $this->assertSame($available, $output->getAvailable());
    }

    /** @test */
    public function it_will_yell_if_writer_does_not_implement_writer_interface()
    {
        $out    = Mockery::mock();
        $output = new Output();

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Class [" . get_class($out) . "] must implement League\CLImate\Util\Writer\WriterInterface.");

        $output->add('out', $out);
    }

    /** @test */
    public function it_will_yell_if_trying_to_add_a_non_existent_nested_writer_key()
    {
        $output = new Output();

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Unable to resolve writer [nothin]");

        $output->add('out', ['nothin']);
    }

    /**
     * @test
     * @doesNotPerformAssertions
     */
    public function it_can_write_to_a_non_default_writer_once()
    {
        $out = Mockery::mock(StdOut::class);
        $out->shouldReceive('write')->once()->with('Second time.');

        $error = Mockery::mock(StdErr::class);
        $error->shouldReceive('write')->once()->with('First time.');

        $output = new Output();

        $output->add('out', $out);
        $output->add('error', $error);
        $output->defaultTo('out');

        $output->once('error')->sameLine()->write('First time.');

        $output->sameLine()->write('Second time.');
    }

    /**
     * @test
     * @doesNotPerformAssertions
     */
    public function it_will_persist_writer_if_told_to()
    {
        $out = Mockery::mock(StdOut::class);
        $out->shouldReceive('write')->once()->with('Second time.');

        $error = Mockery::mock(StdErr::class);
        $error->shouldReceive('write')->times(3)->with('First time.');

        $output = new Output();

        $output->add('out', $out);
        $output->add('error', $error);
        $output->defaultTo('out');

        $output->persist();
        $output->once('error')->sameLine()->write('First time.');
        $output->sameLine()->write('First time.');
        $output->sameLine()->write('First time.');
        $output->persist(false);

        $output->sameLine()->write('Second time.');
    }

    /** @test */
    public function it_can_retrieve_a_writer()
    {
        $buffer = Mockery::mock(Buffer::class);
        $buffer->shouldReceive('write')->once()->with('Oh, hey there.');
        $buffer->shouldReceive('get')->once()->andReturn('Oh, hey there.');

        $output = new Output();

        $output->add('buffer', $buffer);
        $output->defaultTo('buffer');

        $output->sameLine()->write('Oh, hey there.');
        $this->assertSame($output->get('buffer')->get(), 'Oh, hey there.');
    }
}
