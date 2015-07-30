<?php

namespace League\CLImate\Tests;

use League\CLImate\Decorator\Component\Command;

class CommandTest extends TestBase
{
    /** @test */
    public function it_can_add_a_command()
    {
        $command = new Command();
        $command->add('my_new_command', 'that_new_new');

        $this->assertArrayHasKey('my_new_command', $command->commands);
        $this->assertSame($command->commands['my_new_command'], 'that_new_new');
    }

    /** @test */
    public function it_can_retrieve_all_the_commands()
    {
        $command = new Command();
        $this->assertSame($command->commands, $command->all());
    }

    /** @test */
    public function it_can_retrieve_a_command_value()
    {
        $command = new Command();
        $this->assertSame('green', $command->get('info'));
    }

    /** @test */
    public function it_returns_null_for_non_existent_command()
    {
        $command = new Command();
        $this->assertNull($command->get('wat'));
    }

    /** @test */
    public function it_can_set_an_existing_command_as_current()
    {
        $command = new Command();
        $this->assertSame('green', $command->set('info'));
    }

    /** @test */
    public function it_returns_false_when_setting_a_non_existent_command_as_current()
    {
        $command = new Command();
        $this->assertFalse($command->set('wat'));
    }
}
