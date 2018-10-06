<?php

namespace League\CLImate\Util\Writer;

use League\CLImate\Exceptions\RuntimeException;

class File implements WriterInterface
{
    /** @var resource|string */
    protected $resource;

    /** @var boolean $close_locally */
    protected $close_locally = false;

    /** @var boolean $use_locking */
    protected $use_locking = false;

    /** @var boolean $gzip_file */
    protected $gzip_file = false;

    /**
     * @param string|resource $resource
     * @param bool $use_locking
     * @param bool $gzip_file
     */
    public function __construct($resource, $use_locking = false, $gzip_file = false)
    {
        $this->resource    = $resource;
        $this->use_locking = $use_locking;
        $this->gzip_file   = $gzip_file;
    }

    public function lock()
    {
        $this->use_locking = true;

        return $this;
    }

    public function gzipped()
    {
        $this->gzip_file = true;

        return $this;
    }

    /**
     * Write the content to the stream
     *
     * @param  string $content
     */
    public function write($content)
    {
        $resource = $this->getResource();

        if ($this->use_locking) {
            flock($resource, LOCK_EX);
        }

        gzwrite($resource, $content);

        if ($this->use_locking) {
            flock($resource, LOCK_UN);
        }
    }

    protected function getResource()
    {
        if (is_resource($this->resource)) {
            return $this->resource;
        }

        $this->close_locally = true;

        if (!is_writable($this->resource)) {
            throw new RuntimeException("The resource [{$this->resource}] is not writable");
        }

        if (!($this->resource = $this->openResource())) {
            throw new RuntimeException("The resource could not be opened");
        }

        return $this->resource;
    }

    protected function openResource()
    {
        if ($this->gzip_file) {
            return gzopen($this->resource, 'a');
        }

        return fopen($this->resource, 'a');
    }

    public function _destruct()
    {
        if ($this->close_locally) {
            gzclose($this->getResource());
        }
    }
}
