<?php

class TableTest extends PHPUnit_Framework_TestCase
{
    public $cli;

    public function setUp()
    {
        $this->cli = new JoeTannenbaum\CLImate\CLImate;
    }

    /** @test */

    public function it_can_output_a_basic_table()
    {
        ob_start();

        $this->cli->table([
                [
                    'Cell 1',
                    'Cell 2',
                    'Cell 3',
                    'Cell 4',
                ],
        ]);

        $result = ob_get_contents();

        ob_end_clean();

        $should_be = "\e[m-------------------------------------\e[0m\n";
        $should_be .= "\e[m| Cell 1 | Cell 2 | Cell 3 | Cell 4 |\e[0m\n";
        $should_be .= "\e[m-------------------------------------\e[0m\n";

        $this->assertEquals( $should_be, $result );
    }

    /** @test */

    public function it_can_output_an_array_of_objects_table()
    {
        ob_start();

        $this->cli->table([
                (object) [
                    'cell1' => 'Cell 1',
                    'cell2' => 'Cell 2',
                    'cell3' => 'Cell 3',
                    'cell4' => 'Cell 4',
                ],
            ]);

        $result = ob_get_contents();

        ob_end_clean();

        $should_be = "\e[m-------------------------------------\e[0m\n";
        $should_be .= "\e[m| cell1  | cell2  | cell3  | cell4  |\e[0m\n";
        $should_be .= "\e[m=====================================\e[0m\n";
        $should_be .= "\e[m| Cell 1 | Cell 2 | Cell 3 | Cell 4 |\e[0m\n";
        $should_be .= "\e[m-------------------------------------\e[0m\n";

        $this->assertEquals( $should_be, $result );
    }

    /** @test */

    public function it_can_output_an_array_of_associative_arrays_table()
    {
        ob_start();

        $this->cli->table([
                [
                    'cell1' => 'Cell 1',
                    'cell2' => 'Cell 2',
                    'cell3' => 'Cell 3',
                    'cell4' => 'Cell 4',
                ],
            ]);

        $result = ob_get_contents();

        ob_end_clean();

        $should_be = "\e[m-------------------------------------\e[0m\n";
        $should_be .= "\e[m| cell1  | cell2  | cell3  | cell4  |\e[0m\n";
        $should_be .= "\e[m=====================================\e[0m\n";
        $should_be .= "\e[m| Cell 1 | Cell 2 | Cell 3 | Cell 4 |\e[0m\n";
        $should_be .= "\e[m-------------------------------------\e[0m\n";

        $this->assertEquals( $should_be, $result );
    }

}