<?php

require_once 'TestBase.php';

use League\CLImate\TerminalObject\Router\BasicRouter;
use League\CLImate\Decorator\Style;
use League\CLImate\Decorator\NonAnsiParser;
use League\CLImate\Decorator\AnsiParser;

class AnsiTest extends TestBase
{

    /** @test */

    public function it_can_output_with_ansi()
    {
        $router = new BasicRouter();
        $router->output($this->output);

        $style  = new Style();
        $parser = new AnsiParser($style->current(), $style->all());

        $obj = Mockery::mock('League\CLImate\TerminalObject');
        $obj->shouldReceive('result')->once()->andReturn("<green>I am green</green>");
        $obj->shouldReceive('sameLine')->once()->andReturn(false);
        $obj->shouldReceive('getParser')->once()->andReturn($parser);

        $this->shouldWrite("\e[m\e[32mI am green\e[0m\e[0m");

        $router->execute($obj);
    }


    /** @test */

    public function it_can_output_without_ansi()
    {
        $router = new BasicRouter();
        $router->output($this->output);

        $style  = new Style();
        $parser = new NonAnsiParser($style->current(), $style->all());

        $obj = Mockery::mock('League\CLImate\TerminalObject');
        $obj->shouldReceive('result')->once()->andReturn("<green>I am not green</green>");
        $obj->shouldReceive('sameLine')->once()->andReturn(false);
        $obj->shouldReceive('getParser')->once()->andReturn($parser);

        $this->shouldWrite("I am not green");

        $router->execute($obj);
    }

}
