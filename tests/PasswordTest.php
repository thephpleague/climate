<?php

namespace League\CLImate\Tests;

class PasswordTest extends TestBase
{
    /** @test */
    public function it_will_hide_the_user_response()
    {
        $this->shouldReceiveSameLine();
        $this->shouldWrite("\e[mGimmie the secret: \e[0m");
        $this->reader->shouldReceive('hidden')->andReturn('mypasswordyo');

        $input = $this->cli->password('Gimmie the secret:', $this->reader);

        $response = $input->prompt();

        $this->assertSame($response, 'mypasswordyo');
    }
}
