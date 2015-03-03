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

    /** @test */
    public function it_can_write_to_a_file()
    {
        $file   = new League\CLImate\Util\Writer\File($this->file->url());
        $output = new League\CLImate\Util\Output();
        $output->add('file', $file);
        $output->defaultTo('file');

        $output->write("Oh, you're still here.");

        $this->assertSame("Oh, you're still here.\n", $this->file->getContent());
    }

    /** @test */
    public function it_will_accept_a_resource()
    {
        $file   = new League\CLImate\Util\Writer\File(fopen($this->file->url(), 'a'));
        $output = new League\CLImate\Util\Output();
        $output->add('file', $file);
        $output->defaultTo('file');

        $output->write("Oh, you're still here.");

        $this->assertSame("Oh, you're still here.\n", $this->file->getContent());
    }

    /** @test */
    public function it_will_yell_when_a_non_writable_resource_is_passed()
    {
        $this->file->chmod(0477);
        $this->setExpectedException('Exception', 'The resource [' . $this->file->url() . '] is not writable');

        $file   = new League\CLImate\Util\Writer\File($this->file->url());
        $output = new League\CLImate\Util\Output();
        $output->add('file', $file);
        $output->defaultTo('file');

        $output->write("Oh, you're still here.");
    }

    /** @test */
    public function it_will_yell_when_a_non_existent_resource_is_passed()
    {
        $this->setExpectedException('Exception', 'The resource [something-that-doesnt-exist] is not writable');

        $file   = new League\CLImate\Util\Writer\File('something-that-doesnt-exist');
        $output = new League\CLImate\Util\Output();
        $output->add('file', $file);
        $output->defaultTo('file');

        $output->write("Oh, you're still here.");
    }
}
