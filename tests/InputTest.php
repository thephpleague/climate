<?php

require_once 'TestBase.php';

class InputTest extends TestBase
{

    /** @test */
    public function it_can_prompt_for_basic_info()
    {
        $this->shouldReadAndReturn('Not much.');
        $this->shouldReceiveSameLine();
        $this->shouldWrite("\e[mSo what is up? \e[0m");

        $input    = $this->cli->input('So what is up?', $this->reader);
        $response = $input->prompt();

        $this->assertSame('Not much.', $response);
    }

    /** @test */
    public function it_will_only_allow_loose_acceptable_responses()
    {
        $this->shouldReadAndReturn('Not much.');
        $this->shouldReadAndReturn('Everything.');
        $this->shouldReceiveSameLine();
        $this->shouldWrite("\e[mSo what is up? \e[0m", 2);

        $input = $this->cli->input('So what is up?', $this->reader);
        $input->accept(['everything.']);

        $response = $input->prompt();

        $this->assertSame('Everything.', $response);
    }

    /** @test */
    public function it_will_only_allow_strict_acceptable_responses()
    {
        $this->shouldReadAndReturn('everything.');
        $this->shouldReadAndReturn('Everything.');
        $this->shouldReceiveSameLine();
        $this->shouldWrite("\e[mSo what is up? \e[0m", 2);

        $input = $this->cli->input('So what is up?', $this->reader);

        $input->accept(['Everything.']);

        $response = $input->strict()->prompt();

        $this->assertSame('Everything.', $response);
    }

    /** @test */
    public function it_will_allow_an_array_of_acceptable_responses()
    {
        $this->shouldReadAndReturn('stuff.');
        $this->shouldReadAndReturn('Stuff.');
        $this->shouldReceiveSameLine();
        $this->shouldWrite("\e[mSo what is up? \e[0m", 2);

        $input = $this->cli->input('So what is up?', $this->reader);

        $input->accept(['Everything.', 'Stuff.']);

        $response = $input->strict()->prompt();

        $this->assertSame('Stuff.', $response);
    }

    /** @test */
    public function it_will_display_acceptable_responses()
    {
        $this->shouldReadAndReturn('Stuff.');
        $this->shouldReceiveSameLine();
        $this->shouldWrite("\e[mSo what is up? [Everything./Stuff.] \e[0m");

        $input = $this->cli->input('So what is up?', $this->reader);

        $input->accept(['Everything.', 'Stuff.'], true);

        $response = $input->prompt();

        $this->assertSame('Stuff.', $response);
    }

    /** @test */
    public function it_will_display_acceptable_responses_with_same_format_if_input_fails()
    {
        $this->shouldReadAndReturn('Nothing.');
        $this->shouldReadAndReturn('Stuff.');
        $this->shouldReceiveSameLine();
        $this->shouldWrite("\e[mSo what is up? [Everything./Stuff.] \e[0m", 2);

        $input = $this->cli->input('So what is up?', $this->reader);

        $input->accept(['Everything.', 'Stuff.'], true);

        $response = $input->prompt();

        $this->assertSame('Stuff.', $response);
    }

    /** @test */
    public function it_will_format_the_default_acceptable_response()
    {
        $this->shouldReadAndReturn('Stuff.');
        $this->shouldReceiveSameLine();
        $this->shouldWrite("\e[mSo what is up? [\e[1mEverything.\e[0m/Stuff.] \e[0m");

        $input = $this->cli->input('So what is up?', $this->reader);

        $input->accept(['Everything.', 'Stuff.'], true);
        $input->defaultTo('Everything.');

        $response = $input->prompt();

        $this->assertSame('Stuff.', $response);
    }

    /** @test */
    public function it_will_accept_a_closure_as_an_acceptable_response()
    {
        $this->shouldReadAndReturn('everything.');
        $this->shouldReceiveSameLine();
        $this->shouldWrite("\e[mSo what is up? \e[0m");

        $input = $this->cli->input('So what is up?', $this->reader);

        $input->accept(function($response) {
            return ($response == 'everything.');
        });

        $response = $input->prompt();

        $this->assertSame('everything.', $response);
    }

    /** @test */
    public function it_will_fail_via_an_accept_closure()
    {
        $this->shouldReadAndReturn('everything!');
        $this->shouldReadAndReturn('everything.');
        $this->shouldReceiveSameLine();
        $this->shouldWrite("\e[mSo what is up? \e[0m", 2);

        $input = $this->cli->input('So what is up?', $this->reader);

        $input->accept(function($response) {
            return ($response == 'everything.');
        });

        $response = $input->strict()->prompt();

        $this->assertSame('everything.', $response);
    }

    /** @test */
    public function it_will_accept_a_default_if_no_answer_is_given()
    {
        $this->shouldReadAndReturn('');
        $this->shouldReceiveSameLine();
        $this->shouldWrite("\e[mSo what is up? \e[0m");

        $input = $this->cli->input('So what is up?', $this->reader);

        $input->defaultTo('Not much.');

        $response = $input->prompt();

        $this->assertSame('Not much.', $response);
    }

    /** @test */
    public function it_will_accept_multiple_lines()
    {
        $this->shouldReadMultipleLinesAndReturn("Multiple\nLines\x04");
        $this->shouldReceiveSameLine();
        $this->shouldWrite("\e[m>>> \e[0m");
        
        $input = $this->cli->input('>>>', $this->reader);
        $input->multiLine();
        $response = $input->prompt();
    }

    /** @test */
    public function it_will_read_after_eof()
    {
        $this->shouldReadMultipleLinesAndReturn("Multiple\nLines\x04");
        $this->shouldReceiveSameLine();
        $this->shouldWrite("\e[m>>> \e[0m");

        $input = $this->cli->input('>>>', $this->reader);
        $input->multiLine();
        $response = $input->prompt();

        $this->shouldReadMultipleLinesAndReturn("Multiple\nLines\nAgain\x04");
        $this->shouldReceiveSameLine();
        $this->shouldWrite("\e[m>>> \e[0m");

        $input = $this->cli->input('>>>', $this->reader);
        $input->multiLine();
        $response = $input->prompt();
    }
}
