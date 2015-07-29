<?php

require_once __DIR__ . '/../vendor/mikey179/vfsStream/src/main/php/org/bovigo/vfs/vfsStream.php';
require_once 'TestBase.php';

use org\bovigo\vfs\vfsStream;

class FileTest extends TestBase
{
    protected $file;

    public function setUp()
    {
        $root       = vfsStream::setup();
        $this->file = vfsStream::newFile('log')->at($root);
    }

    protected function getFileMock()
    {
        $file_class = 'League\CLImate\Util\Writer\File[setLockState]';
        $file       = \Mockery::mock($file_class, func_get_args())
                                ->shouldAllowMockingProtectedMethods();

        return $file;
    }

    /** @test */
    public function it_can_write_to_a_file()
    {
        $file = $this->getFileMock($this->file->url());
        $output = new League\CLImate\Util\Output();
        $output->add('file', $file);
        $output->defaultTo('file');

        $output->write("Oh, you're still here.");

        $this->assertSame("Oh, you're still here.\n", $this->file->getContent());
    }

    /** @test */
    public function it_will_accept_a_resource()
    {
        $resource = fopen($this->file->url(), 'a');
        $file     = $this->getFileMock($resource);
        $output   = new League\CLImate\Util\Output();
        $output->add('file', $file);
        $output->defaultTo('file');

        $output->write("Oh, you're still here.");

        $this->assertSame("Oh, you're still here.\n", $this->file->getContent());
    }

    /** @test */
    public function it_can_lock_the_file()
    {
        $resource = fopen($this->file->url(), 'a');
        $file     = $this->getFileMock($resource);

        $file->shouldReceive('setLockState')->once()->with($resource, LOCK_EX);
        $file->shouldReceive('setLockState')->once()->with($resource, LOCK_UN);

        $file->lock();

        $output = new League\CLImate\Util\Output();
        $output->add('file', $file);
        $output->defaultTo('file');

        $output->write("Oh, you're still here.");

        $this->assertSame("Oh, you're still here.\n", $this->file->getContent());
    }

    /** @test */
    public function it_can_write_to_a_gzipped_file()
    {
        $resource = fopen($this->file->url(), 'a');
        $file     = $this->getFileMock($resource);

        $file->gzipped();

        $output = new League\CLImate\Util\Output();
        $output->add('file', $file);
        $output->defaultTo('file');

        $output->write("Oh, you're still here.");

        $this->assertSame("Oh, you're still here.\n", $this->file->getContent());
    }

    /** @test */
    public function it_will_yell_when_a_non_writable_resource_is_passed()
    {
        $this->file->chmod(0444);
        $this->setExpectedException('Exception');

        $file   = $this->getFileMock($this->file->url());
        $output = new League\CLImate\Util\Output();
        $output->add('file', $file);
        $output->defaultTo('file');

        $output->write("Oh, you're still here.");
    }

    /** @test */
    public function it_will_yell_when_a_non_existent_resource_is_passed()
    {
        $this->setExpectedException('Exception', 'The resource [something-that-doesnt-exist] is not writable');

        $file   = $this->getFileMock('something-that-doesnt-exist');
        $output = new League\CLImate\Util\Output();
        $output->add('file', $file);
        $output->defaultTo('file');

        $output->write("Oh, you're still here.");
    }
}
