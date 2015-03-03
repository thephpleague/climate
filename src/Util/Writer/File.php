<?php

namespace League\CLImate\Util\Writer;


class File implements WriterInterface
{
    /* @var resource|string */
    protected $resource;

    /* @var boolean $close_locally */
    protected $close_locally = false;

    /* @var boolean $use_locking */
    protected $use_locking = false;

    /* @var boolean $gzip_file */
    protected $gzip_file = false;

    /**
     * @param string|resource $resource
     * @param bool $use_locking
     * @param bool $gzip_file
     */
    public function __construct($resource, $use_locking=false, $gzip_file=false)
    {
        $this->resource     = $resource;
        $this->use_locking  = $use_locking;
        $this->gzip_file    = $gzip_file;
    }

    protected function getResource()
    {
        if ( ! is_resource($this->resource) ) {
            return $this->resource;
        }
        $this->close_locally = true;
        if ( ! is_writable($this->resource) ) {
            throw new \Exception("The resource {$this->resource} is not writable");
        }
        $this->resource = $this->gzip_file ? gzopen($this->resource, 'a') : fopen($this->resource, 'a');
        if ( ! $this->resource ) {
            throw new \Exception("The resource could not be opened");
        }
        return $this->resource;
    }

    /**
     * Write the content to the stream
     *
     * @param  string $content
     */
    public function write($content)
    {
        $resource = $this->getResource();
        if ( $this->use_locking ) {
            flock($resource, LOCK_EX);
        }
        gzwrite($resource, $content);
        if ( $this->use_locking ) {
            flock($resource, LOCK_UN);
        }
    }

    public function _destruct()
    {
        if ( $this->close_locally ) {
            gzclose($this->getResource());
        }
    }
}