<?php

require_once 'TestBase.php';

class InlineTest extends TestBase
{

    /** @test */
    public function it_can_output_inline()
    {
        $should_be = [
            "content1_",
            "content2_",
        ];

        $this->output->shouldReceive("sameLine");
        foreach ($should_be as $content) {
            $this->shouldWrite("\e[m" . $content . "\e[0m");
        }

        $this->shouldHavePersisted(2);

        foreach ($should_be as $content) {
            $this->cli->inline($content);
        }
    }
}
