<?php

class DumpTest extends PHPUnit_Framework_TestCase
{
    public $cli;

    public function setUp()
    {
        $this->cli = new JoeTannenbaum\CLImate\CLImate;
    }

    /** @test */

    public function it_can_output_an_object_as_json()
    {
        ob_start();

        $this->cli->dump([
                    'Thing 1',
                    'Thing 2',
                    'Thing 3',
                    'Thing 4',
                ]);

        $result = ob_get_contents();

        ob_end_clean();

        file_put_contents('wat', $result);

        $should_be = [];

        $should_be[] = 'array(4) {';
        $should_be[] = '  [0]=>';
        $should_be[] = '  string(7) "Thing 1"';
        $should_be[] = '  [1]=>';
        $should_be[] = '  string(7) "Thing 2"';
        $should_be[] = '  [2]=>';
        $should_be[] = '  string(7) "Thing 3"';
        $should_be[] = '  [3]=>';
        $should_be[] = '  string(7) "Thing 4"';
        $should_be[] = '}';
        $should_be[] = '';

        $should_be = "\e[m" . implode( "\n", $should_be ) . "\e[0m\n";

        $this->assertSame( $should_be, $result );
    }

}