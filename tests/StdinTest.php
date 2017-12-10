<?php

namespace League\CLImate\Tests;

use League\CLImate\Tests\CustomObject\StdinFake;
use League\CLImate\Tests\CustomObject\StdinFakeSetStdin;
use League\CLImate\Util\Reader\Stdin;

require_once 'StdinGlobalMock.php';

class StdinTest extends TestBase
{
    /** @test */
    public function it_can_read_a_line_from_stdin()
    {
        $stdin = new Stdin;

        self::$functions->shouldReceive('fopen')
                        ->once()
                        ->with('php://stdin', 'r')
                        ->andReturn('resource');

        self::$functions->shouldReceive('fgets')
                        ->once()
                        ->with('resource', 1024)
                        ->andReturn('I hear you loud and clear.');

        $response = $stdin->line();

        $this->assertSame('I hear you loud and clear.', $response);
    }

    /** @test */
    public function it_can_read_multiple_lines_from_stdin()
    {
        $stdin = new Stdin;

        self::$functions->shouldReceive('fopen')
                        ->once()
                        ->with('php://stdin', 'r')
                        ->andReturn('resource');

        self::$functions->shouldReceive('stream_get_contents')
                        ->once()
                        ->with('resource')
                        ->andReturn('I hear you loud and clear.');

        $response = $stdin->multiLine();

        $this->assertSame('I hear you loud and clear.', $response);
    }

    /** @test */
    public function it_can_several_characters_from_stdin()
    {
        $stdin = new Stdin;

        self::$functions->shouldReceive('fopen')
                        ->once()
                        ->with('php://stdin', 'r')
                        ->andReturn('resource');

        self::$functions->shouldReceive('fread')
                        ->once()
                        ->with('resource', 6)
                        ->andReturn('I hear');

        $response = $stdin->char(6);

        $this->assertSame('I hear', $response);
    }

    /** @test */
    public function it_can_read_but_hide_typing_user()
    {
        $stdin = new Stdin;
        $mock = \Mockery::mock('alias:Seld\CliPrompt\CliPrompt');
        $mock->shouldReceive('hiddenPrompt')->once();
        $stdin->hidden();
    }

    /** @test */
    public function it_set_stdin_expect_exception()
    {
        $stdin = new Stdin;
        $this->expectException(\Exception::class);
        self::$functions->shouldReceive('fopen')
            ->once()
            ->with('php://stdin', 'r')
            ->andReturn(false);
        $stdin->line();
    }

    /** @test */
    public function it_close_stdin()
    {
        $stdin = new StdinFake;
        self::$functions->shouldReceive('fopen')
            ->andReturn('resource');

        $stdin->changeStdin(fopen('php://memory', 'r'));
        $stdin->callSetSdinFake();
    }

    /** @test */
    public function it_get_stdIn_return_if_feof_false()
    {
        $stdin = new StdinFake;
        self::$functions->shouldReceive('fopen')
            ->andReturn('resource');

        self::$functions->shouldReceive('feof')
            ->andReturn(false);

        $stdin->changeStdin(fopen('php://memory', 'r'));
        $stdin->callGetStdIn();
    }

    /** @test */
    public function it_get_stdin_exception()
    {
        $stdin = new StdinFakeSetStdin;
        $this->expectException(\Exception::class);
        $stdin->callGetStdIn();
    }
}

