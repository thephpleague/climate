<?php

namespace League\CLImate\TerminalObject\Dynamic;

use League\CLImate\Util\Reader\ReaderInterface;
use League\CLImate\Util\Reader\Stdin;

abstract class InputAbstract extends DynamicTerminalObject
{
    /**
     * The prompt text
     *
     * @var string $prompt
     */
    protected $prompt;

    /**
     * An instance of ReaderInterface
     *
     * @var \League\CLImate\Util\Reader\ReaderInterface $reader
     */
    protected $reader;

    /**
     * Do it! Prompt the user for information!
     *
     * @return string
     */
    abstract public function prompt();

    /**
     * Format the prompt incorporating spacing and any acceptable options
     *
     * @return string
     */
    abstract protected function promptFormatted();
}
