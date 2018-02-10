<?php

namespace League\CLImate\Tests\TerminalObject\Basic;

use League\CLImate\Tests\TestBase;

use function json_encode;
use function str_replace;

class JsonTest extends TestBase
{
    /**
     * @test
     * @doesNotPerformAssertions
     */
    public function it_can_output_an_object_as_json()
    {
        $should_be = json_encode((object) [
                    'cell1' => 'Cell 1',
                    'cell2' => 'Cell 2',
                    'cell3' => 'Cell 3',
                    'cell4' => 'Cell 4',
                ], JSON_PRETTY_PRINT);

        $this->shouldWrite("\e[m" . $should_be . "\e[0m");
        $this->shouldHavePersisted();

        $this->cli->json((object) [
                    'cell1' => 'Cell 1',
                    'cell2' => 'Cell 2',
                    'cell3' => 'Cell 3',
                    'cell4' => 'Cell 4',
                ]);
    }

    /**
     * We do this test specifically because json escapes the tags,
     * we want to make sure we're taking care of that
     *
     * @test
     * @doesNotPerformAssertions
     */
    public function it_can_output_json_with_tags()
    {
        $should_be = json_encode((object) [
            "cell1" => 'Cell 1',
            "cell2" => 'Cell 2',
            "cell3" => 'Cell 3',
            "cell4" => 'Cell 4',
        ], \JSON_PRETTY_PRINT);

        $should_be = str_replace('Cell 4', "\e[5mCell 4\e[0m", $should_be);

        $this->shouldWrite("\e[m" . $should_be . "\e[0m");
        $this->shouldHavePersisted();

        $this->cli->json((object) [
            "cell1" => "Cell 1",
            "cell2" => "Cell 2",
            "cell3" => "Cell 3",
            "cell4" => "<blink>Cell 4</blink>",
        ]);
    }

    /**
     * @doesNotPerformAssertions
     */
    public function test_we_dont_escape_slashes()
    {
        $this->shouldWrite("\e[m{\n    \"package\": \"league/climate\"\n}\e[0m");
        $this->shouldHavePersisted();

        $this->cli->json(["package" => "league/climate"]);
    }
}
