<?php

require_once 'TestBase.php';

class ConfirmTest extends TestBase
{

    /** @test */

    public function it_will_return_true_for_y()
    {
        $reader = Mockery::mock('League\CLImate\Util\Reader');
        $reader->shouldReceive('line')->once()->andReturn('y');

        ob_start();

        $input = $this->cli->confirm('Keep going?', $reader);

        $response = $input->confirmed();

        $result = ob_get_contents();

        ob_end_clean();

        $should_be = "\e[mKeep going? [y/n] \e[0m";

        $this->assertSame($result, $should_be);
        $this->assertTrue($response);
    }

    /** @test */

    public function it_will_return_false_for_n()
    {
        $reader = Mockery::mock('League\CLImate\Util\Reader');
        $reader->shouldReceive('line')->once()->andReturn('n');

        ob_start();

        $input = $this->cli->confirm('Keep going?', $reader);

        $response = $input->confirmed();

        $result = ob_get_contents();

        ob_end_clean();

        $should_be = "\e[mKeep going? [y/n] \e[0m";

        $this->assertSame($result, $should_be);
        $this->assertFalse($response);
    }

    /** @test */

    public function it_will_only_allow_strict_confirmations()
    {
        $reader = Mockery::mock('League\CLImate\Util\Reader');
        $reader->shouldReceive('line')->once()->andReturn('Y');
        $reader->shouldReceive('line')->once()->andReturn('y');

        ob_start();

        $input = $this->cli->confirm('Keep going?', $reader);

        $response = $input->confirmed();

        $result = ob_get_contents();

        ob_end_clean();

        $should_be = "\e[mKeep going? [y/n] \e[0m\e[mKeep going? [y/n] \e[0m";

        $this->assertSame($should_be, $result);
    }

}
