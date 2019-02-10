<?php

namespace League\CLImate\TerminalObject\Dynamic;

use League\CLImate\Util\Reader\ReaderInterface;
use function in_array;
use function strtolower;
use function substr;

class Confirm extends Input
{


    /**
     * @inheritdoc
     */
    public function __construct($prompt, ReaderInterface $reader = null)
    {
        parent::__construct($prompt, $reader);

        $this->default = "n";
    }


    /**
     * Let us know if the user confirmed.
     *
     * @return bool
     */
    public function confirmed()
    {
        if (in_array($this->default, ["y", "yes"], true)) {
            $this->prompt .= " [Y/n]";
        } else {
            $this->prompt .= " [y/N]";
        }

        $this->accept(['y', 'yes', 'n', 'no'], false);

        $response = strtolower($this->prompt());

        return (substr($response, 0, 1) === 'y');
    }
}
