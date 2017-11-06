<?php

namespace League\CLImate;

use League\CLImate\Argument\Argument;
use League\CLImate\Argument\Filter;
use League\CLImate\Argument\Parser;
use League\CLImate\Argument\Summary;

class Command
{
    /**
     * @var string $name The name of the command.
     */
    private $name;

    /**
     * @var CLImate $climate The parent instance to handle output.
     */
    private $climate;

    /**
     * An array of arguments passed to the program.
     *
     * @var Argument[] $arguments
     */
    private $arguments = [];

    /**
     * A program's description.
     *
     * @var string $description
     */
    private $description;

    /**
     * Filter class to find various types of arguments
     *
     * @var \League\CLImate\Argument\Filter $filter
     */
    private $filter;

    /**
     * Summary builder class
     *
     * @var \League\CLImate\Argument\Summary $summary
     */
    private $summary;

    /**
     * Argument parser class
     *
     * @var \League\CLImate\Argument\Parser $parser
     */
    private $parser;

    public function __construct($name, CLImate $climate)
    {
        $this->name = $name;
        $this->climate = $climate;

        $this->filter  = new Filter;
        $this->summary = new Summary;
        $this->parser  = new Parser;
    }

    /**
     * Add an argument.
     *
     * @throws \Exception if $argument isn't an array or Argument object.
     * @param Argument|string $argument
     * @param $options
     */
    public function add($argument, array $options = [])
    {
        if (is_string($argument)) {
            $argument = Argument::createFromArray($argument, $options);
        }

        if (!($argument instanceof Argument)) {
            throw new \Exception('Please provide an argument name or object.');
        }

        $this->arguments[$argument->name()] = $argument;
    }


    /**
     * Determine if an argument exists.
     *
     * @param string $name
     * @return bool
     */
    public function exists($name)
    {
        return isset($this->arguments[$name]);
    }


    /**
     * Retrieve an argument's value.
     *
     * @param string $name
     * @return string|int|float|bool|null
     */
    public function get($name)
    {
        return isset($this->arguments[$name]) ? $this->arguments[$name]->value() : null;
    }


    /**
     * Retrieve all arguments.
     *
     * @return Argument[]
     */
    public function all()
    {
        return $this->arguments;
    }


    /**
     * Determine if an argument has been defined on the command line.
     *
     * This can be useful for making sure an argument is present on the command
     * line before parse()'ing them into argument objects.
     *
     * @param string $name
     * @param array $argv
     *
     * @return bool
     */
    public function defined($name, array $argv = null)
    {
        // The argument isn't defined if it's not defined by the calling code.
        if (!$this->exists($name)) {
            return false;
        }

        $argument = $this->arguments[$name];
        $command_arguments = $this->parser->arguments($argv);

        foreach ($command_arguments as $command_argument) {
            if ($this->isArgument($argument, $command_argument)) {
                return true;
            }
        }

        return false;
    }


    /**
     * Check if the defined argument matches the command argument.
     *
     * @param Argument $argument
     * @param string $command_argument
     *
     * @return bool
     */
    private function isArgument($argument, $command_argument)
    {
        $possibilities = [
            $argument->prefix()     => "-{$argument->prefix()}",
            $argument->longPrefix() => "--{$argument->longPrefix()}",
        ];

        foreach ($possibilities as $key => $search) {
            if ($key && strpos($command_argument, $search) === 0) {
                return true;
            }
        }

        return false;
    }


    /**
     * Retrieve all arguments as key/value pairs.
     *
     * @return array
     */
    public function toArray()
    {
        $return = [];

        foreach ($this->all() as $name => $argument) {
            $return[$name] = $argument->value();
        }

        return $return;
    }


    /**
     * Set a program's description.
     *
     * @param string $description
     */
    public function description($description)
    {
        $this->description = trim($description);
    }


    /**
     * Output a script's usage statement.
     *
     * @param CLImate $climate
     * @param array $argv
     */
    public function usage(CLImate $climate, array $argv = null)
    {
        $this->summary
                ->setClimate($climate)
                ->setDescription($this->description)
                ->setCommand($this->parser->command($argv))
                ->setFilter($this->filter, $this->all())
                ->output();
    }


    /**
     * Parse command line arguments into CLImate arguments.
     *
     * @throws \Exception if required arguments aren't defined.
     * @param array $argv
     */
    public function parse(array $argv = null)
    {
        $this->parser->setFilter($this->filter, $this->all());

        $this->parser->parse($argv);
    }


    /**
     * Get the trailing arguments
     *
     * @return string|null
     */
    public function trailing()
    {
        return $this->parser->trailing();
    }
}
