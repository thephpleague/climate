<?php

namespace CLImate\TerminalObject;

class Json extends BaseTerminalObject
{
    /**
     * The data to convert to JSON
     *
     * @var mixed $data
     */

    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Return the data as JSON
     *
     * @return string
     */

    public function result()
    {
        return json_encode($this->data, JSON_PRETTY_PRINT);
    }
}
