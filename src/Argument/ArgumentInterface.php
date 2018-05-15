<?php

namespace League\CLImate\Argument;

interface ArgumentInterface
{
    /**
     * Build a new command argument from an array.
     *
     * @param string $name
     * @param array $params
     *
     * @return Argument
     */
    public static function createFromArray($name, array $params);
}
