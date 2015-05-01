<?php

namespace League\CLImate\Util\Reader;

use Seld\CliPrompt\CliPrompt;

class Stdin implements ReaderInterface
{
    /**
     * Read the line typed in by the user
     *
     * @return string
     */
    public function line()
    {
        $response = trim(fgets(STDIN, 1024));

        return $response;
    }

    /**
     * Read one character
     *
     * @param int $count
     *
     * @return string
     */
    public function char($count = 1)
    {
        return fread(STDIN, $count);
    }

    /**
     * Read the line, but hide what the user is typing
     *
     * @return string
     */
    public function hidden()
    {
        return CliPrompt::hiddenPrompt();
    }

}
