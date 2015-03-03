<?php

namespace League\CLImate\Util\Writer;


class File implements WriterInterface
{
    /* @var resource */
    protected $resource;

    /**
     * @param $resource
     */
    public function __construct($resource)
    {
        $this->resource = $resource;
    }

    /**
     * Write the content to the stream
     *
     * @param  string $content
     */
    public function write($content)
    {
        fwrite($this->resource, $content);
    }

    public function _destruct()
    {
        fclose($this->resource);
    }
}