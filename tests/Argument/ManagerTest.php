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

    public function testProvidedReturnsTrueWhenValueGivenOnCommandLine()
    {
        $this->manager->add([
            'foo' => ['prefix' => 'f', 'defaultValue' => 'bar'],
        ]);

        $this->manager->parse(['command', '-f', 'baz']);

        $this->assertTrue($this->manager->provided('foo'));
    }

    public function testProvidedReturnsFalseWhenFallingBackToDefault()
    {
        $this->manager->add([
            'foo' => ['prefix' => 'f', 'defaultValue' => 'bar'],
        ]);

        $this->manager->parse(['command']);

        $this->assertFalse($this->manager->provided('foo'));
        $this->assertEquals('bar', $this->manager->get('foo'));
    }

    public function testProvidedReturnsFalseForUnknownArgument()
    {
        $this->assertFalse($this->manager->provided('missing'));
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

    public function testItParsesAValueTakingArgumentThatIsLastWithoutAWarning()
    {
        $this->manager->add([
            'name' => ['prefix' => 'n', 'longPrefix' => 'name', 'defaultValue' => 'default-name'],
        ]);

        set_error_handler(static function (int $errno, string $errstr): bool {
            throw new \ErrorException($errstr, 0, $errno);
        });

        try {
            // "-n" is the last element but not at a reindexed offset, so reading the
            // next offset must not raise "Undefined array key".
            $this->manager->parse(['command', 'somefile', '-n']);
        } finally {
            restore_error_handler();
        }

        // No value was supplied for -n, so it must fall back to its default.
        $this->assertFalse($this->manager->provided('name'));
        $this->assertEquals('default-name', $this->manager->get('name'));
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

    public function testItSuggestAlternativesToUnknowArguments()
    {
        $this->manager->add([
            'user' => [
                'longPrefix' => 'user',
            ],
            'password' => [
                'longPrefix' => 'password',
            ],
            'flag' => [
                'longPrefix' => 'flag',
                'noValue'    => true,
            ],
        ]);

        $argv = [
            'test-script',
            '--user=baz',
            '--pass=123',
            '--fag',
            '--xyz',
        ];

        $this->manager->parse($argv);
        $processed = $this->manager->getUnknowPrefixedArgumentsAndSuggestions();

        $this->assertCount(3, $processed);
        $this->assertEquals('password', $processed['pass']);
        $this->assertEquals('flag', $processed['fag']);
        $this->assertEquals('', $processed['xyz']);
    }
}
