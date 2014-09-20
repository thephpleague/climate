<?php

namespace League\CLImate\Util;

class Reader implements ReaderInterface {

    /**
     * Read the line typed in by the user
     *
     * @return string
     */

    public function line()
    {
        $handler  = fopen('php://stdin','r');
        $response = trim(fgets($handler, 1024));
        fclose ($handler);

        return $response;
    }

}
