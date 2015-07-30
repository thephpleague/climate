<?php

namespace League\CLImate\Tests;

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
}
