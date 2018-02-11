<?php

namespace League\CLImate\Tests\Util\Reader;

use League\CLImate\Tests\TestBase;
use League\CLImate\Util\Reader\Stream;

class StreamTest extends TestBase
{
    private $filename;
    private $stream;
    private $file;

    public function setUp(): void
    {
        $this->filename = tempnam(sys_get_temp_dir(), "climate_");

        $this->stream = new Stream($this->filename);
        $this->file = new \SplFileObject($this->filename, "w");
    }


    public function tearDown(): void
    {
        unset($this->file);
        unlink($this->filename);
    }


    public function testLine()
    {
        $this->file->fwrite("Line A\n");
        $this->file->fwrite("Line B\n");

        $response = $this->stream->line();
        $this->assertSame("Line A", $response);

        $response = $this->stream->line();
        $this->assertSame("Line B", $response);
    }


    public function testMutliLine()
    {
        $this->file->fwrite("Line one\n");
        $this->file->fwrite("Line two\n");

        $response = $this->stream->multiLine();

        $this->assertSame("Line one\nLine two", $response);
    }


    public function testChar()
    {
        $this->file->fwrite("123456789");

        $response = $this->stream->char(6);

        $this->assertSame("123456", $response);
    }


    public function testReopenStream()
    {
        $this->file->fwrite("Line 1\n");
        $this->file->fwrite("Line 2\n");

        $response = $this->stream->multiLine();
        $this->assertSame("Line 1\nLine 2", $response);

        $response = $this->stream->line();
        $this->assertSame("Line 1", $response);
    }
}
