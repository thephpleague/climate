<?php

require_once 'TestBase.php';

use League\CLImate\Argument\Argument;

class ArgumentTest extends TestBase
{
    /** @test */
    public function it_throws_an_exception_when_setting_an_unknown_cast_type()
    {
        $this->setExpectedException(
            'Exception',
            "An argument may only be cast to the data type 'string', 'int', 'float', or 'bool'."
        );

        Argument::createFromArray('invalid-cast-type', [
            'castTo' => 'invalid',
        ]);
    }

    /** @test */
    public function it_throws_an_exception_when_building_arguments_from_an_unknown_type()
    {
        $this->setExpectedException(
            'Exception',
            'Please provide an argument name or object.'
        );

        $this->cli->arguments->add(new stdClass);
    }

    public function provide_cast_types_and_values()
    {
        return [
            'to string' => ['string', 'a string',],
            'to int' => ['int', '1234',],
            'to float' => ['float', '12.34',],
            'to boolean' => ['bool', '1'],
        ];
    }

    /**
     * @test
     * @dataProvider provide_cast_types_and_values
     * @param string $castTo
     * @param string $value
     */
    public function it_can_cast_different_value_data_types($castTo, $value)
    {
        $argument = Argument::createFromArray('test', [
            'castTo' => $castTo,
        ]);

        $argument->setValue($value);
        $this->assertInternalType($castTo, $argument->value());
    }

    /** @test */
    public function it_casts_to_bool_when_defined_only()
    {
        $argument = Argument::createFromArray('invalid-cast-type', [
            'noValue' => true,
        ]);

        $this->assertEquals('bool', $argument->castTo());
    }

    /** @test */
    public function it_builds_arguments_from_a_single_array()
    {
        // Test Description
        //
        // Usage: test-script [-b both-prefixes, --both both-prefixes] [-d, --defined] [--long only-long-prefix] [-r required] [-s only-short-prefix] [-v default-value (default: test)] [no-prefix]
        //
        // Required Arguments:
        //     -r required
        //         Required
        //
        // Optional Arguments:
        //     -b both-prefixes, --both both-prefixes
        //         Both short and long prefixes
        //     -d, --defined
        //         True when defined
        //     -s only-short-prefix
        //         Only short prefix
        //     --long only-long-prefix
        //         Only long prefix
        //     -v default-value (default: test)
        //         Has a default value

        $this->output->shouldReceive("sameLine");
        $this->shouldWrite("\e[mTest Description\e[0m");
        $this->shouldWrite("\e[m\e[0m");
        $this->shouldWrite("\e[mUsage: test-script "
                            . "[-b both-prefixes, --both both-prefixes] [-d, --defined] "
                            . "[--long only-long-prefix] [-r required] [-s only-short-prefix] "
                            . "[-v default-value (default: test)] [no-prefix]\e[0m");

        $this->shouldWrite("\e[m\e[0m");
        $this->shouldWrite("\e[mRequired Arguments:\e[0m");

        $this->shouldWrite("\e[m\t\e[0m");
        $this->shouldWrite("\e[m-r required\e[0m");
        $this->shouldWrite("\e[m\t\t\e[0m");
        $this->shouldWrite("\e[mRequired\e[0m");

        $this->shouldWrite("\e[m\e[0m");
        $this->shouldWrite("\e[mOptional Arguments:\e[0m");

        $this->shouldWrite("\e[m\t\e[0m");
        $this->shouldWrite("\e[m-b both-prefixes, --both both-prefixes\e[0m");
        $this->shouldWrite("\e[m\t\t\e[0m");
        $this->shouldWrite("\e[mBoth short and long prefixes\e[0m");

        $this->shouldWrite("\e[m\t\e[0m");
        $this->shouldWrite("\e[m-d, --defined\e[0m");
        $this->shouldWrite("\e[m\t\t\e[0m");
        $this->shouldWrite("\e[mTrue when defined\e[0m");

        $this->shouldWrite("\e[m\t\e[0m");
        $this->shouldWrite("\e[m--long only-long-prefix\e[0m");
        $this->shouldWrite("\e[m\t\t\e[0m");
        $this->shouldWrite("\e[mOnly long prefix\e[0m");

        $this->shouldWrite("\e[m\t\e[0m");
        $this->shouldWrite("\e[m-s only-short-prefix\e[0m");
        $this->shouldWrite("\e[m\t\t\e[0m");
        $this->shouldWrite("\e[mOnly short prefix\e[0m");

        $this->shouldWrite("\e[m\t\e[0m");
        $this->shouldWrite("\e[m-v default-value (default: test)\e[0m");
        $this->shouldWrite("\e[m\t\t\e[0m");
        $this->shouldWrite("\e[mHas a default value\e[0m");
        $this->shouldHavePersisted(31);

        $this->cli->description('Test Description');
        $this->cli->arguments->add([
            'only-short-prefix' => [
                'prefix'      => 's',
                'description' => 'Only short prefix',
            ],
            'only-long-prefix' => [
                'longPrefix'  => 'long',
                'description' => 'Only long prefix',
            ],
            'both-prefixes' => [
                'prefix'      => 'b',
                'longPrefix'  => 'both',
                'description' => 'Both short and long prefixes',
            ],
            'no-prefix' => [
                'description' => 'Not defined by a prefix',
            ],
            'defined-only' => [
                'prefix'      => 'd',
                'longPrefix'  => 'defined',
                'description' => 'True when defined',
                'noValue'     => true,
            ],
            'required' => [
                'prefix'      => 'r',
                'description' => 'Required',
                'required'    => true,
            ],
            'default-value' => [
                'prefix'       => 'v',
                'description'  => 'Has a default value',
                'defaultValue' => 'test',
            ],
        ]);

        $command = 'test-script';
        $this->cli->usage([$command]);
    }

    /** @test */
    public function it_can_parse_arguments()
    {
        $this->cli->arguments->add([
            'only-short-prefix' => [
                'prefix' => 's',
            ],
            'only-long-prefix' => [
                'longPrefix' => 'long',
            ],
            'both-prefixes' => [
                'prefix'     => 'b',
                'longPrefix' => 'both',
            ],
            'both-equals' => [
                'longPrefix' => 'both-equals',
            ],
            'no-prefix' => [],
            'defined-only' => [
                'prefix'     => 'd',
                'longPrefix' => 'defined',
                'noValue'    => true,
            ],
        ]);

        $argv = [
            'test-script',
            '-s',
            'foo',
            '--long',
            'bar',
            '-b=both',
            '-d',
            '--both-equals=both_equals',
            'no_prefix_value',
            '-unknown',
            'after_non_prefixed'
        ];

        $this->cli->arguments->parse($argv);
        $processed = $this->cli->arguments->toArray();

        $this->assertCount(6, $processed);
        $this->assertEquals('foo', $processed['only-short-prefix']);
        $this->assertEquals('bar', $processed['only-long-prefix']);
        $this->assertEquals('both', $processed['both-prefixes']);
        $this->assertEquals('both_equals', $processed['both-equals']);
        $this->assertEquals('no_prefix_value', $processed['no-prefix']);
        $this->assertTrue($processed['defined-only']);
        $this->assertEquals('foo', $this->cli->arguments->get('only-short-prefix'));
    }

    /** @test */
    public function it_throws_an_exception_when_required_arguments_are_not_defined()
    {
        $this->setExpectedException(
            'Exception',
            'The following arguments are required: [-r required-value] [-r1 required-value-1].'
        );

        $this->cli->arguments->add([
            'required-value' => [
                'prefix'   => 'r',
                'required' => true,
            ],
            'required-value-1' => [
                'prefix'   => 'r1',
                'required' => true,
            ],
            'optional-value' => [
                'prefix' => 'o',
            ],
        ]);

        $argv = ['test-script', '-o', 'foo'];
        $this->cli->arguments->parse($argv);
    }

    /** @test */
    public function it_can_detect_when_arguments_are_defined()
    {
        $this->cli->arguments->add([
            'argument' => [
                'prefix' => 'a',
            ],
            'another-argument' => [
                'prefix' => 'b',
            ],
            'long-argument' => [
                'longPrefix' => 'c',
            ],
        ]);

        $argv = ['test-script', '-a', 'foo', '--c=bar'];

        $this->assertTrue($this->cli->arguments->defined('argument', $argv));
        $this->assertTrue($this->cli->arguments->defined('long-argument', $argv));
        $this->assertFalse($this->cli->arguments->defined('another-argument', $argv));
        $this->assertFalse($this->cli->arguments->defined('nonexistent', $argv));
    }

}
