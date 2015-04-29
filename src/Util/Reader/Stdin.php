<?php

namespace League\CLImate\Util\Reader;

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

    public function char($count = 1)
    {
        return fread(STDIN, $count);
    }

}
