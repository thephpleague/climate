<?php

namespace League\CLImate\Tests\TerminalObject\Basic;

use League\CLImate\Tests\TestBase;

class DrawTest extends TestBase
{
    protected function drawWorks()
    {
        $this->shouldWrite("\e[m __          ______  _____  _  __ _____\e[0m");
        $this->shouldWrite("\e[m \ \        / / __ \|  __ \| |/ // ____|\e[0m");
        $this->shouldWrite("\e[m  \ \  /\  / / |  | | |__) | ' /| (___\e[0m");
        $this->shouldWrite("\e[m   \ \/  \/ /| |  | |  _  /|  <  \___ \\\e[0m");
        $this->shouldWrite("\e[m    \  /\  / | |__| | | \ \| . \ ____) |\e[0m");
        $this->shouldWrite("\e[m     \/  \/   \____/|_|  \_\_|\_\_____/\e[0m");
        $this->shouldHavePersisted();
    }


    private function draw404(): void
    {
        $this->shouldWrite("\e[m  _  _    ___  _  _\e[0m");
        $this->shouldWrite("\e[m | || |  / _ \| || |\e[0m");
        $this->shouldWrite("\e[m | || |_| | | | || |_\e[0m");
        $this->shouldWrite("\e[m |__   _| | | |__   _|\e[0m");
        $this->shouldWrite("\e[m    | | | |_| |  | |\e[0m");
        $this->shouldWrite("\e[m    |_|  \___/   |_|\e[0m");
        $this->shouldHavePersisted();
    }


    /**
     * @test
     * @doesNotPerformAssertions
     */
    public function it_can_draw_something()
    {
        $this->shouldWrite("\e[m     ( )\e[0m");
        $this->shouldWrite("\e[m      H\e[0m");
        $this->shouldWrite("\e[m      H\e[0m");
        $this->shouldWrite("\e[m     _H_\e[0m");
        $this->shouldWrite("\e[m  .-'-.-'-.\e[0m");
        $this->shouldWrite("\e[m /         \\\e[0m");
        $this->shouldWrite("\e[m|           |\e[0m");
        $this->shouldWrite("\e[m|   .-------'._\e[0m");
        $this->shouldWrite("\e[m|  / /  '.' '. \\\e[0m");
        $this->shouldWrite("\e[m|  \ \ @   @ / /\e[0m");
        $this->shouldWrite("\e[m|   '---------'\e[0m");
        $this->shouldWrite("\e[m|    _______|\e[0m");
        $this->shouldWrite("\e[m|  .'-+-+-+|\e[0m");
        $this->shouldWrite("\e[m|  '.-+-+-+|\e[0m");
        $this->shouldWrite("\e[m|    \"\"\"\"\"\" |\e[0m");
        $this->shouldWrite("\e[m'-.__   __.-'\e[0m");
        $this->shouldWrite("\e[m     \"\"\"\e[0m");
        $this->shouldHavePersisted();

        $this->cli->draw('bender');
    }

    /**
     * @test
     * @doesNotPerformAssertions
     */
    public function it_404s_when_it_gets_invalid_art()
    {
        $this->draw404();
        $this->cli->draw('something-that-doesnt-exist');
    }

    /**
     * @test
     * @doesNotPerformAssertions
     */
    public function it_can_take_a_custom_art_directory()
    {
        $this->drawWorks();
        $this->cli->addArt(__DIR__ . \DIRECTORY_SEPARATOR . '..' . \DIRECTORY_SEPARATOR . '..' . \DIRECTORY_SEPARATOR . 'art');
        $this->cli->draw('works');
    }

    /**
     * @test
     * @doesNotPerformAssertions
     */
    public function it_can_take_a_custom_art_directory_with_a_trailing_slash()
    {
        $this->drawWorks();
        $this->cli->addArt(__DIR__ . \DIRECTORY_SEPARATOR . '..' . \DIRECTORY_SEPARATOR . '..' . \DIRECTORY_SEPARATOR . 'art' . \DIRECTORY_SEPARATOR);
        $this->cli->draw('works');
    }

    /**
     * @test
     * @doesNotPerformAssertions
     */
    public function it_can_chain_the_art_setting()
    {
        $this->drawWorks();
        $this->cli->addArt(__DIR__ . \DIRECTORY_SEPARATOR . '..' . \DIRECTORY_SEPARATOR . '..' . \DIRECTORY_SEPARATOR . 'art')->draw('works');
    }


    /**
     * Ensure we don't use the path to match the file name.
     * https://github.com/thephpleague/climate/issues/130
     * @doesNotPerformAssertions
     */
    public function testAddArt1()
    {
        $this->shouldWrite("\e[mart\e[0m");
        $this->shouldWrite("\e[m\e[0m");
        $this->shouldHavePersisted();

        $this->cli->addArt(__DIR__ . \DIRECTORY_SEPARATOR . '..' . \DIRECTORY_SEPARATOR . '..' . \DIRECTORY_SEPARATOR . "art/");
        $this->cli->draw("art");
    }


    /**
     * Ensure we can draw files without extensions.
     * @doesNotPerformAssertions
     */
    public function testDraw1()
    {
        $this->shouldWrite("\e[m           __\e[0m");
        $this->shouldWrite("\e[m    ____  / /_  ____\e[0m");
        $this->shouldWrite("\e[m   / __ \\/ __ \\/ __ \\\e[0m");
        $this->shouldWrite("\e[m  / /_/ / / / / /_/ /\e[0m");
        $this->shouldWrite("\e[m / .___/_/ /_/ .___/\e[0m");
        $this->shouldWrite("\e[m/_/         /_/\e[0m");
        $this->shouldHavePersisted();

        $this->cli->draw("php");
    }


    /**
     * Ensure we don't draw an image unless the filename matches exactly.
     * https://github.com/thephpleague/climate/issues/155
     * @doesNotPerformAssertions
     */
    public function testDraw2()
    {
        $this->draw404();
        $this->cli->draw("the-leag");
    }
}
