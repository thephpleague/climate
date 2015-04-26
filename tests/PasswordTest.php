<?php

require_once 'TestBase.php';

class PasswordTest extends TestBase
{

    /** @test */
    public function it_will_hide_the_user_response()
    {
        $this->util->system->shouldReceive('canAccessBash')->andReturn(true);
        $this->util->system->shouldReceive('hiddenResponsePrompt')
                            ->with("\e[mGimmie the secret: \e[0m")
                            ->andReturn('mypasswordyo');

        $input = $this->cli->password('Gimmie the secret:', $this->reader);

        $response = $input->prompt();

        $this->assertSame($response, 'mypasswordyo');
    }

    /** @test */
    public function it_will_yell_if_bash_isnt_accessible()
    {
        $this->setExpectedException(
            'Exception',
            'Cannot access bash, unable to hide response.'
        );

        $this->util->system->shouldReceive('canAccessBash')->andReturn(false);

        $input = $this->cli->password('Gimmie the secret:', $this->reader);
        $input->prompt();
    }

}
