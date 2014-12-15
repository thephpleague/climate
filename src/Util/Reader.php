<?php

namespace League\CLImate\Util;

class Reader implements ReaderInterface
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

}
