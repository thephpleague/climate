<?php

require_once 'TestBase.php';

class TableTest extends TestBase
{

    /** @test */

    public function it_can_output_a_basic_table()
    {
        $this->shouldWrite("\e[m-------------------------------------\e[0m");
        $this->shouldWrite("\e[m| Cell 1 | Cell 2 | Cell 3 | Cell 4 |\e[0m");
        $this->shouldWrite("\e[m-------------------------------------\e[0m");

        $this->cli->table([
                [
                    'Cell 1',
                    'Cell 2',
                    'Cell 3',
                    'Cell 4',
                ],
        ]);
    }

    /** @test */

    public function it_can_output_an_array_of_objects_table()
    {

        $this->shouldWrite("\e[m-------------------------------------\e[0m");
        $this->shouldWrite("\e[m| cell1  | cell2  | cell3  | cell4  |\e[0m");
        $this->shouldWrite("\e[m=====================================\e[0m");
        $this->shouldWrite("\e[m| Cell 1 | Cell 2 | Cell 3 | Cell 4 |\e[0m");
        $this->shouldWrite("\e[m-------------------------------------\e[0m");

        $this->cli->table([
                (object) [
                    'cell1' => 'Cell 1',
                    'cell2' => 'Cell 2',
                    'cell3' => 'Cell 3',
                    'cell4' => 'Cell 4',
                ],
            ]);
    }

    /** @test */

    public function it_can_output_an_array_of_associative_arrays_table()
    {
        $this->shouldWrite("\e[m-------------------------------------\e[0m");
        $this->shouldWrite("\e[m| cell1  | cell2  | cell3  | cell4  |\e[0m");
        $this->shouldWrite("\e[m=====================================\e[0m");
        $this->shouldWrite("\e[m| Cell 1 | Cell 2 | Cell 3 | Cell 4 |\e[0m");
        $this->shouldWrite("\e[m-------------------------------------\e[0m");

        $this->cli->table([
                [
                    'cell1' => 'Cell 1',
                    'cell2' => 'Cell 2',
                    'cell3' => 'Cell 3',
                    'cell4' => 'Cell 4',
                ],
            ]);
    }

    /** @test */

    public function it_can_persist_a_style_on_the_table()
    {
        $this->shouldWrite("\e[31m-------------------------------------\e[0m");
        $this->shouldWrite("\e[31m| cell1  | cell2  | cell3  | cell4  |\e[0m");
        $this->shouldWrite("\e[31m=====================================\e[0m");
        $this->shouldWrite("\e[31m| Cell 1 | Cell 2 | Cell 3 | Cell 4 |\e[0m");
        $this->shouldWrite("\e[31m-------------------------------------\e[0m");

        $this->cli->redTable([
                [
                    'cell1' => 'Cell 1',
                    'cell2' => 'Cell 2',
                    'cell3' => 'Cell 3',
                    'cell4' => 'Cell 4',
                ],
            ]);
    }

    /** @test */

    public function it_can_handle_tags_within_the_data()
    {
        $this->shouldWrite("\e[m-------------------------------------\e[0m");
        $this->shouldWrite("\e[m| cell1  | cell2  | cell3  | cell4  |\e[0m");
        $this->shouldWrite("\e[m=====================================\e[0m");
        $this->shouldWrite("\e[m| Cell \e[31m1\e[0m | Cell 2 | Cell 3 | Cell 4 |\e[0m");
        $this->shouldWrite("\e[m-------------------------------------\e[0m");

        $this->cli->table([
                [
                    'cell1' => 'Cell <red>1</red>',
                    'cell2' => 'Cell 2',
                    'cell3' => 'Cell 3',
                    'cell4' => 'Cell 4',
                ],
            ]);
    }

    /** @test */

    public function it_can_handle_multi_byte_characters()
    {
        $this->shouldWrite("\e[m-------------------------------------\e[0m");
        $this->shouldWrite("\e[m| cell1  | cell2  | cell3  | cell4  |\e[0m");
        $this->shouldWrite("\e[m=====================================\e[0m");
        $this->shouldWrite("\e[m| Cell Ω | Cell 2 | Cell 3 | Cell 4 |\e[0m");
        $this->shouldWrite("\e[m-------------------------------------\e[0m");

        $this->cli->table([
                [
                    'cell1' => 'Cell Ω',
                    'cell2' => 'Cell 2',
                    'cell3' => 'Cell 3',
                    'cell4' => 'Cell 4',
                ],
            ]);
    }

}
