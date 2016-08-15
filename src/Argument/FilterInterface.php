<?php

namespace League\CLImate\Argument;

interface FilterInterface
{
    /**
     * Set the available arguments
     *
     * @param array $arguments
     */
    public function setArguments(array $arguments);
}
