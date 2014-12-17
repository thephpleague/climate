<?php

namespace League\CLImate;

use League\CLImate\Util\Output;
use League\CLImate\Util\Writer\StdErr;

final class Terminal
{
    /**
     * CLImate object outputting to the StdErr stream
     * @var League\CLImate\CLImate
     */
    private $stdErr;

    /**
     * CLImate object outputting to the StdOut stream
     * @var League\CLImate\CLImate
     */
    private $stdOut;

    /**
     * create a new instance of Stdio
     *
     * @param League\CLImate\CLImate $out
     * @param League\CLImate\CLImate $err
     */
    public function __construct(CLImate $out = null, CLImate $err = null)
    {
        $this->stdOut = $out ?: new CLImate();
        $this->stdErr = $err ?: new CLImate(new Output(new StdErr()));
    }

    /**
     * return the specified CLImate object
     *
     * @return League\CLImate\CLImate
     */
    public function __get($value)
    {
        return $this->$value;
    }
}
