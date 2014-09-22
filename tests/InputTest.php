<?php

require_once 'TestBase.php';

class InputTest extends TestBase
{

    /** @test */

    public function it_can_prompt_for_basic_info()
    {
        $reader = Mockery::mock('League\CLImate\Util\Reader');
        $reader->shouldReceive('line')->once()->andReturn('Not much.');

        ob_start();

        $input = $this->cli->input('So what is up?', $reader);

        $response = $input->prompt();

        $result = ob_get_contents();

        ob_end_clean();

        $should_be = "\e[mSo what is up? \e[0m";

        $this->assertSame($result, $should_be);
        $this->assertSame('Not much.', $response);
    }

    /** @test */

    public function it_will_only_allow_loose_acceptable_responses()
    {
        $reader = Mockery::mock('League\CLImate\Util\Reader');
        $reader->shouldReceive('line')->once()->andReturn('Not much.');
        $reader->shouldReceive('line')->once()->andReturn('Everything.');

        ob_start();

        $input = $this->cli->input('So what is up?', $reader);

        $input->accept(['everything.']);

        $response = $input->prompt();

        $result = ob_get_contents();

        ob_end_clean();

        $should_be = "\e[mSo what is up? \e[0m\e[mSo what is up? \e[0m";

        $this->assertSame($should_be, $result);
        $this->assertSame('Everything.', $response);
    }

    /** @test */

    public function it_will_only_allow_strict_acceptable_responses()
    {
        $reader = Mockery::mock('League\CLImate\Util\Reader');
        $reader->shouldReceive('line')->once()->andReturn('everything.');
        $reader->shouldReceive('line')->once()->andReturn('Everything.');

        ob_start();

        $input = $this->cli->input('So what is up?', $reader);

        $input->accept(['Everything.']);

        $response = $input->strict()->prompt();

        $result = ob_get_contents();

        ob_end_clean();

        $should_be = "\e[mSo what is up? \e[0m\e[mSo what is up? \e[0m";

        $this->assertSame($should_be, $result);
        $this->assertSame('Everything.', $response);
    }

    /** @test */

    public function it_will_allow_an_array_of_acceptable_responses()
    {
        $reader = Mockery::mock('League\CLImate\Util\Reader');
        $reader->shouldReceive('line')->once()->andReturn('stuff.');
        $reader->shouldReceive('line')->once()->andReturn('Stuff.');

        ob_start();

        $input = $this->cli->input('So what is up?', $reader);

        $input->accept(['Everything.', 'Stuff.']);

        $response = $input->strict()->prompt();

        $result = ob_get_contents();

        ob_end_clean();

        $should_be = "\e[mSo what is up? \e[0m\e[mSo what is up? \e[0m";

        $this->assertSame($should_be, $result);
        $this->assertSame('Stuff.', $response);
    }

    /** @test */

    public function it_will_display_acceptable_responses()
    {
        $reader = Mockery::mock('League\CLImate\Util\Reader');
        $reader->shouldReceive('line')->once()->andReturn('Stuff.');

        ob_start();

        $input = $this->cli->input('So what is up?', $reader);

        $input->accept(['Everything.', 'Stuff.'], true);

        $response = $input->prompt();

        $result = ob_get_contents();

        ob_end_clean();

        $should_be = "\e[mSo what is up? [Everything./Stuff.] \e[0m";

        $this->assertSame($should_be, $result);
        $this->assertSame('Stuff.', $response);
    }

}
