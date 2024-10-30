<?php

namespace League\CLImate\Tests\Argument;

use League\CLImate\Argument\Argument;
use League\CLImate\Argument\Manager;
use PHPUnit\Framework\TestCase;

class ManagerTest extends TestCase
{
    private $manager;

    public function setUp(): void
    {
        $this->manager = new Manager();
    }


    public function testDefined1()
    {
        $argument = Argument::createFromArray("test", [
            "prefix"        =>  "t",
            "longPrefix"    =>  "test",
        ]);
        $this->manager->add($argument);

        $result = $this->manager->defined("test", ["command", "--test"]);

        $this->assertTrue($result);
    }
    public function testDefined2()
    {
        $result = $this->manager->defined("test");

        $this->assertFalse($result);
    }
    public function testDefined3()
    {
        $argument = Argument::createFromArray("lorem", [
            "prefix"        =>  "l",
            "longPrefix"    =>  "Лорем",
        ]);
        $this->manager->add($argument);

        $result = $this->manager->defined("lorem", ["command", "--Лорем"]);

        $this->assertTrue($result);
    }

    public function testItParsesAnOptionalArgument()
    {
        $this->manager->add([
            'foo' => ['prefix' => 'f'],
            'bar' => ['prefix' => 'b']
        ]);

        $this->manager->parse(['command', '-f', '-b', 'abc']);

        $this->assertEquals('', $this->manager->get('foo'));
    }

    public function testItStoresTrailingInArray()
    {
        $this->manager->add([
            'foo' => ['prefix' => 'f']
        ]);

        $this->manager->parse(['command', '-f', '--', 'test', 'trailing with spaces']);

        $this->assertEquals('test trailing with spaces', $this->manager->trailing());
        $this->assertEquals(['test', 'trailing with spaces'], $this->manager->trailingArray());
    }
}
