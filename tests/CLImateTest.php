<?php

namespace League\CLImate\Tests;

use League\CLImate\Exceptions\InvalidArgumentException;
use League\CLImate\Exceptions\UnexpectedValueException;
use League\CLImate\Tests\CustomObject\Basic;
use League\CLImate\Tests\CustomObject\BasicObject;
use League\CLImate\Tests\CustomObject\BasicObjectArgument;
use League\CLImate\Tests\CustomObject\Dummy;
use League\CLImate\Tests\CustomObject\Dynamic;

class CLImateTest extends TestBase
{
    /**
     * @test
     * @doesNotPerformAssertions
     */
    public function it_can_echo_out_a_string()
    {
        $this->shouldWrite("\e[mThis would go out to the console.\e[0m");
        $this->shouldHavePersisted();
        $this->cli->out('This would go out to the console.');
    }

    /**
     * @test
     * @doesNotPerformAssertions
     */
    public function it_can_chain_the_out_method()
    {
        $this->shouldWrite("\e[mThis is a line.\e[0m");
        $this->shouldWrite("\e[mThis is another line.\e[0m");
        $this->shouldHavePersisted(2);
        $this->cli->out('This is a line.')->out('This is another line.');
    }

    /**
     * @test
     * @doesNotPerformAssertions
     */
    public function it_can_write_content_to_a_different_output()
    {
        $this->shouldWrite("\e[mThis is to the buffer.\e[0m");
        $this->output->shouldReceive('defaultTo')->with('out')->once();
        $this->output->shouldReceive('once')->with('buffer')->once();
        $this->shouldHavePersisted();

        // Just double check that this is the default output
        $this->cli->output->defaultTo('out');
        $this->cli->to('buffer')->out('This is to the buffer.');
    }

    /**
     * @test
     * @doesNotPerformAssertions
     */
    public function it_can_be_extended_using_a_basic_object_as_string()
    {
        $this->shouldWrite("\e[mBy Custom Object: This is something my custom object is handling.\e[0m");
        $this->shouldHavePersisted();

        $this->cli->extend(Basic::class);
        $this->cli->basic('This is something my custom object is handling.');
    }

    /**
     * @test
     * @doesNotPerformAssertions
     */
    public function it_can_be_extended_using_a_basic_object()
    {
        $this->shouldWrite("\e[mThis just outputs this.\e[0m");
        $this->shouldHavePersisted();

        $this->cli->extend(new BasicObject());
        $this->cli->basicObject();
    }

    /**
     * @test
     * @doesNotPerformAssertions
     */
    public function it_can_be_extended_using_a_basic_object_with_argument_setter()
    {
        $this->shouldWrite("\e[mHey: This is the thing that will print to the console.\e[0m");
        $this->shouldHavePersisted();

        $this->cli->extend(new BasicObjectArgument());
        $this->cli->basicObjectArgument('This is the thing that will print to the console.');
    }

    /** @test */
    public function it_can_be_extended_using_a_dynamic_object()
    {
        $this->cli->extend(Dynamic::class);
        $obj = $this->cli->dynamic();

        $this->assertInstanceOf(Dynamic::class, $obj);
    }

    /** @test */
    public function it_will_yell_if_extending_and_class_doesnt_exist()
    {
        $class = "NoSuchClass";
        $this->expectException(UnexpectedValueException::class);
        $this->expectExceptionMessage("Class does not exist: {$class}");
        $this->cli->extend($class);
    }

    /** @test */
    public function it_will_yell_if_it_doesnt_implement_proper_interfaces()
    {
        $class = Dummy::class;
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Class must implement either");
        $this->cli->extend($class);
    }

    /**
     * @test
     * @doesNotPerformAssertions
     */
    public function it_will_accept_a_custom_key_for_an_extension()
    {
        $this->shouldWrite("\e[mBy Custom Object: This is something my custom object is handling.\e[0m");
        $this->shouldHavePersisted();

        $this->cli->extend(Basic::class, 'myCustomMethod');
        $this->cli->myCustomMethod('This is something my custom object is handling.');
    }

    /** @test */
    public function it_will_accept_an_array_of_extensions()
    {
        $this->shouldWrite("\e[mBy Custom Object: This is something my custom object is handling.\e[0m");
        $this->shouldHavePersisted();

        $extensions = [
            Basic::class,
            Dynamic::class,
        ];

        $this->cli->extend($extensions);

        $this->cli->basic('This is something my custom object is handling.');

        $obj = $this->cli->dynamic();

        $this->assertInstanceOf(Dynamic::class, $obj);
    }

    /** @test */
    public function it_will_accept_an_array_of_extensions_with_custom_keys()
    {
        $this->shouldWrite("\e[mBy Custom Object: This is something my custom object is handling.\e[0m");
        $this->shouldHavePersisted();

        $extensions = [
            'whatever'  => Basic::class,
            'something' => Dynamic::class,
        ];

        $this->cli->extend($extensions);

        $this->cli->whatever('This is something my custom object is handling.');

        $obj = $this->cli->something();

        $this->assertInstanceOf(Dynamic::class, $obj);
    }
}
