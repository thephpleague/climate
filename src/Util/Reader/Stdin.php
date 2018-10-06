<?php

namespace League\CLImate\Util\Reader;

use League\CLImate\Exceptions\RuntimeException;
use Seld\CliPrompt\CliPrompt;

class Stdin implements ReaderInterface
{
    protected $stdIn = false;

    /**
     * Read the line typed in by the user
     *
     * @return string
     */
    public function line()
    {
        return trim(fgets($this->getStdIn(), 1024));
    }

    /**
     * Read from STDIN until EOF (^D) is reached
     *
     * @return string
     */
    public function multiLine()
    {
        return trim(stream_get_contents($this->getStdIn()));
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
        return fread($this->getStdIn(), $count);
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

    /**
     * Return a valid STDIN, even if it previously EOF'ed
     *
     * Lazily re-opens STDIN after hitting an EOF
     *
     * @return resource
     * @throws RuntimeException
     */
    protected function getStdIn()
    {
        if ($this->stdIn && !feof($this->stdIn)) {
            return $this->stdIn;
        }

        try {
            $this->setStdIn();
        } catch (\Error $e) {
            throw new RuntimeException('Unable to read from STDIN', 0, $e);
        }

        return $this->stdIn;
    }

    /**
     * Attempt to set the stdin property
     *
     * @return void
     * @throws RuntimeException
     */
    protected function setStdIn()
    {
        if ($this->stdIn !== false) {
            fclose($this->stdIn);
        }

        $this->stdIn = fopen('php://stdin', 'r');

        if (!$this->stdIn) {
            throw new RuntimeException('Unable to read from STDIN');
        }
    }
}
