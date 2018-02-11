<?php

namespace League\CLImate\Util\Reader;

use League\CLImate\Exceptions\RuntimeException;
use Seld\CliPrompt\CliPrompt;

class Stream implements ReaderInterface
{
    /**
     * @var string $filename The name of the file this stream represents.
     */
    private $filename;

    /**
     * @var resource $resource The underlying stream this object represents.
     */
    private $resource;


    /**
     * Create a new instance.
     *
     * @param string $filename The name of the file this stream represents
     */
    public function __construct($filename)
    {
        $this->filename = $filename;
    }


    /**
     * Read a line from the stream
     *
     * @return string
     */
    public function line()
    {
        return trim(fgets($this->getResource(), 1024));
    }


    /**
     * Read from the stream until EOF (^D) is reached
     *
     * @return string
     */
    public function multiLine()
    {
        return trim(stream_get_contents($this->getResource()));
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
        return fread($this->getResource(), $count);
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
     * Return a valid resource, even if it previously EOF'ed.
     *
     * @return resource
     */
    private function getResource()
    {
        if ($this->resource && !feof($this->resource)) {
            return $this->resource;
        }

        if ($this->resource !== null) {
            fclose($this->resource);
        }

        $this->resource = fopen($this->filename, "r");
        if (!$this->resource) {
            throw new RuntimeException("Unable to read from {$this->filename}");
        }

        return $this->resource;
    }
}
