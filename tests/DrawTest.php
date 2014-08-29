<?php

class DrawTest extends PHPUnit_Framework_TestCase
{
    public $cli;

    public function setUp()
    {
        $this->cli = new JoeTannenbaum\CLImate\CLImate;
    }

    /** @test */

    public function it_can_draw_something()
    {
        ob_start();

        $this->cli->draw('bender');

        $result = ob_get_contents();

        ob_end_clean();

        $should_be = "\e[m     ( )\e[0m\n";
        $should_be .= "\e[m      H\e[0m\n";
        $should_be .= "\e[m      H\e[0m\n";
        $should_be .= "\e[m     _H_\e[0m\n";
        $should_be .= "\e[m  .-'-.-'-.\e[0m\n";
        $should_be .= "\e[m /         \\\e[0m\n";
        $should_be .= "\e[m|           |\e[0m\n";
        $should_be .= "\e[m|   .-------'._\e[0m\n";
        $should_be .= "\e[m|  / /  '.' '. \\\e[0m\n";
        $should_be .= "\e[m|  \ \ @   @ / /\e[0m\n";
        $should_be .= "\e[m|   '---------'\e[0m\n";
        $should_be .= "\e[m|    _______|\e[0m\n";
        $should_be .= "\e[m|  .'-+-+-+|\e[0m\n";
        $should_be .= "\e[m|  '.-+-+-+|\e[0m\n";
        $should_be .= "\e[m|    \"\"\"\"\"\" |\e[0m\n";
        $should_be .= "\e[m'-.__   __.-'\e[0m\n";
        $should_be .= "\e[m     \"\"\"\e[0m\n";

        $this->assertSame( $should_be, $result );
    }

    /** @test */

    public function it_404s_when_it_gets_invalid_art()
    {
        ob_start();

        $this->cli->draw('something-that-doesnt-exist');

        $result = ob_get_contents();

        ob_end_clean();

        $should_be = "\e[m  _  _    ___  _  _\e[0m\n";
        $should_be .= "\e[m | || |  / _ \| || |\e[0m\n";
        $should_be .= "\e[m | || |_| | | | || |_\e[0m\n";
        $should_be .= "\e[m |__   _| | | |__   _|\e[0m\n";
        $should_be .= "\e[m    | | | |_| |  | |\e[0m\n";
        $should_be .= "\e[m    |_|  \___/   |_|\e[0m\n";

        $this->assertSame( $should_be, $result );
    }

    /** @test */

    public function it_can_take_a_custom_art_directory()
    {
        ob_start();

        $this->cli->addArt( __DIR__ . '/art' );

        $this->cli->draw('works');

        $result = ob_get_contents();

        ob_end_clean();

        $should_be = "\e[m __          ______  _____  _  __ _____\e[0m\n";
        $should_be .= "\e[m \ \        / / __ \|  __ \| |/ // ____|\e[0m\n";
        $should_be .= "\e[m  \ \  /\  / / |  | | |__) | ' /| (___\e[0m\n";
        $should_be .= "\e[m   \ \/  \/ /| |  | |  _  /|  <  \___ \\\e[0m\n";
        $should_be .= "\e[m    \  /\  / | |__| | | \ \| . \ ____) |\e[0m\n";
        $should_be .= "\e[m     \/  \/   \____/|_|  \_\_|\_\_____/\e[0m\n";

        $this->assertSame( $should_be, $result );
    }

    /** @test */

    public function it_can_take_a_custom_art_directory_with_a_trailing_slash()
    {
        ob_start();

        $this->cli->addArt( __DIR__ . '/art/' );

        $this->cli->draw('works');

        $result = ob_get_contents();

        ob_end_clean();

        $should_be = "\e[m __          ______  _____  _  __ _____\e[0m\n";
        $should_be .= "\e[m \ \        / / __ \|  __ \| |/ // ____|\e[0m\n";
        $should_be .= "\e[m  \ \  /\  / / |  | | |__) | ' /| (___\e[0m\n";
        $should_be .= "\e[m   \ \/  \/ /| |  | |  _  /|  <  \___ \\\e[0m\n";
        $should_be .= "\e[m    \  /\  / | |__| | | \ \| . \ ____) |\e[0m\n";
        $should_be .= "\e[m     \/  \/   \____/|_|  \_\_|\_\_____/\e[0m\n";

        $this->assertSame( $should_be, $result );
    }

    /** @test */

    public function it_can_chain_the_art_setting()
    {
        ob_start();

        $this->cli->addArt( __DIR__ . '/art' )->draw('works');

        $result = ob_get_contents();

        ob_end_clean();

        $should_be = "\e[m __          ______  _____  _  __ _____\e[0m\n";
        $should_be .= "\e[m \ \        / / __ \|  __ \| |/ // ____|\e[0m\n";
        $should_be .= "\e[m  \ \  /\  / / |  | | |__) | ' /| (___\e[0m\n";
        $should_be .= "\e[m   \ \/  \/ /| |  | |  _  /|  <  \___ \\\e[0m\n";
        $should_be .= "\e[m    \  /\  / | |__| | | \ \| . \ ____) |\e[0m\n";
        $should_be .= "\e[m     \/  \/   \____/|_|  \_\_|\_\_____/\e[0m\n";

        $this->assertSame( $should_be, $result );
    }

}