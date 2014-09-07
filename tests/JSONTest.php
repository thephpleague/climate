<?php

require_once 'TestBase.php';

class JSONTest extends TestBase
{

    /** @test */

    public function it_can_output_an_object_as_json()
    {
        ob_start();

        $this->cli->json((object) [
                    'cell1' => 'Cell 1',
                    'cell2' => 'Cell 2',
                    'cell3' => 'Cell 3',
                    'cell4' => 'Cell 4',
                ]);

        $result = ob_get_contents();

        ob_end_clean();

        $should_be = json_encode((object) [
                    'cell1' => 'Cell 1',
                    'cell2' => 'Cell 2',
                    'cell3' => 'Cell 3',
                    'cell4' => 'Cell 4',
                ], JSON_PRETTY_PRINT );

        $should_be = "\e[m" . $should_be . "\e[0m\n";

        $this->assertSame($should_be, $result);
    }

    /**
     * We do this test specifically because json escapes the tags,
     * we want to make sure we're taking care of that
     *
     * @test */

    public function it_can_output_json_with_tags()
    {
        ob_start();

        $this->cli->json((object) [
                    'cell1' => 'Cell 1',
                    'cell2' => 'Cell 2',
                    'cell3' => 'Cell 3',
                    'cell4' => '<blink>Cell 4</blink>',
                ]);

        $result = ob_get_contents();

        ob_end_clean();

        $should_be = json_encode((object) [
                    'cell1' => 'Cell 1',
                    'cell2' => 'Cell 2',
                    'cell3' => 'Cell 3',
                    'cell4' => 'Cell 4',
                ], JSON_PRETTY_PRINT );

        $should_be = str_replace('Cell 4', "\e[5mCell 4\e[0m", $should_be);

        $should_be = "\e[m" . $should_be . "\e[0m\n";

        $this->assertSame($should_be, $result);
    }

}
