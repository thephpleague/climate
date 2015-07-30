<?php

namespace League\CLImate\Tests;

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

    /** @test */
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

    /** @test */
    public function it_404s_when_it_gets_invalid_art()
    {
        $this->shouldWrite("\e[m  _  _    ___  _  _\e[0m");
        $this->shouldWrite("\e[m | || |  / _ \| || |\e[0m");
        $this->shouldWrite("\e[m | || |_| | | | || |_\e[0m");
        $this->shouldWrite("\e[m |__   _| | | |__   _|\e[0m");
        $this->shouldWrite("\e[m    | | | |_| |  | |\e[0m");
        $this->shouldWrite("\e[m    |_|  \___/   |_|\e[0m");
        $this->shouldHavePersisted();

        $this->cli->draw('something-that-doesnt-exist');
    }

    /** @test */
    public function it_can_take_a_custom_art_directory()
    {
        $this->drawWorks();
        $this->cli->addArt(__DIR__ . '/art');
        $this->cli->draw('works');
    }

    /** @test */
    public function it_can_take_a_custom_art_directory_with_a_trailing_slash()
    {
        $this->drawWorks();
        $this->cli->addArt(__DIR__ . '/art/');
        $this->cli->draw('works');
    }

    /** @test */
    public function it_can_chain_the_art_setting()
    {
        $this->drawWorks();
        $this->cli->addArt(__DIR__ . '/art')->draw('works');
    }
}
