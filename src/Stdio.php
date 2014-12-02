<?php

namespace League\CLImate;

use League\CLImate\Util\Output;
use League\CLImate\Util\Writer\StdErr;

final class Stdio
{
    /**
     * CLImate object outputting to the StdErr stream
     * @var League\CLImate\CLImate
     */
    private $err;

    /**
     * CLImate object outputting to the StdOut stream
     * @var League\CLImate\CLImate
     */
    private $out;

    /**
     * create a new instance of Stdio
     *
     * @param League\CLImate\CLImate $out [description]
     * @param League\CLImate\CLImate $err [description]
     */
    public function __construct(CLImate $out = null, CLImate $err = null)
    {
        $this->out = $out ?: new CLImate();
        $this->err = $err ?: new CLImate(new Output(new StdErr()));
    }

    /**
     * return the CLImate StdErr object
     *
     * @return League\CLImate\CLImate
     */
    public function err()
    {
        return $this->err;
    }

    /**
     * return the CLImate StdOut object
     *
     * @return League\CLImate\CLImate
     */
    public function out()
    {
        return $this->out;
    }
}
