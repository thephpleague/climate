<?php

namespace League\CLImate\Argument;

use League\CLImate\CLImate;

interface ManagerInterface
{
    /**
     * Add an argument.
     *
     * @throws \Exception if $argument isn't an array or Argument object.
     * @param Argument|string|array $argument
     * @param array $options
     */
    public function add($argument, array $options = []);

    /**
     * Determine if an argument exists.
     *
     * @param string $name
     * @return bool
     */
    public function exists($name);

    /**
     * Retrieve an argument's value.
     *
     * @param string $name
     * @return string|int|float|bool|null
     */
    public function get($name);

    /**
     * Retrieve all arguments.
     *
     * @return Argument[]
     */
    public function all();

    /**
     * Set a program's description.
     *
     * @param string $description
     */
    public function description($description);

    /**
     * Output a script's usage statement.
     *
     * @param CLImate $climate
     * @param array $argv
     */
    public function usage(CLImate $climate, array $argv = null);
}
