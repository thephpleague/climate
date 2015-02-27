<?php

namespace League\CLImate\Argument;

use League\CLImate\CLImate;

class Manager
{
    /**
     * An array of arguments passed to the program.
     *
     * @var Argument[] $arguments
     */
    protected $arguments = [];

    /**
     * A program's description.
     *
     * @var string $description
     */
    protected $description;

    /**
     * Filter class to find various types of arguments
     *
     * @var League\CLImate\Argument\Filter $filter
     */
    protected $filter;

    public function __construct()
    {
        $this->filter = new Filter();
    }

    /**
     * Add an argument.
     *
     * @throws \Exception if $argument isn't an array or Argument object.
     * @param Argument|string|array $argument
     * @param $options
     */
    public function add($argument, array $options = [])
    {
        if (is_array($argument)) {
            $this->addMany($argument);
            return;
        }

        if (is_string($argument)) {
            $argument = Argument::createFromArray($argument, $options);
        }

        if (!($argument instanceof Argument)) {
            throw new \Exception('Please provide an argument name or object.');
        }

        $this->arguments[$argument->name()] = $argument;
    }

    /**
     * Add multiple arguments to a CLImate script.
     *
     * @param array $arguments
     */
    protected function addMany(array $arguments = [])
    {
        foreach ($arguments as $name => $options) {
            $this->add($name, $options);
        }
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
        $command_arguments = $this->getArguments($argv);

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
    protected function isArgument($argument, $command_argument)
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
        $this->filter->setArguments($this->all());

        // Print the description if it's defined.
        if ($this->description) {
            $climate->out($this->description)->br();
        }

        // Print the usage statement with the arguments without a prefix at the
        // end.
        $climate->out(
            "Usage: {$this->getCommand($argv)} "
            . $this->buildShortSummary(array_merge($this->filter->withPrefix(), $this->filter->withoutPrefix()))
        );

        // Print argument details.
        $this->printArguments($climate, $this->filter->required(), 'required');
        $this->printArguments($climate, $this->filter->optional(), 'optional');
    }

    /**
     * Print out the argument list
     *
     * @param CLImate $climate
     * @param array $arguments
     * @param string $type
     */
    protected function printArguments(CLImate $climate, $arguments, $type)
    {
        if (count($arguments) == 0) {
            return;
        }

        $climate->br()->out(ucwords($type) . " Arguments:");

        foreach ($arguments as $argument) {
            $climate->tab()->out($argument->buildSummary());

            if ($argument->description()) {
                $climate->tab(2)->out($argument->description());
            }
        }
    }

    /**
     * Parse command line arguments into CLImate arguments.
     *
     * @throws \Exception if required arguments aren't defined.
     * @param array $argv
     */
    public function parse(array $argv = null)
    {
        $this->filter->setArguments($this->all());

        $cliArguments      = $this->getArguments($argv);
        $unParsedArguments = $this->parsePrefixedArguments($cliArguments);

        $this->parseNonPrefixedArguments($unParsedArguments);

        // After parsing find out which arguments were required but not
        // defined on the command line.
        $missingArguments = $this->filter->missing();

        if (count($missingArguments) > 0) {
            throw new \Exception(
                'The following arguments are required: '
                . $this->buildShortSummary($missingArguments) . '.'
            );
        }
    }

    /**
     * Build a short summary of a list of arguments.
     *
     * @param Argument[] $arguments
     * @return string
     */
    protected function buildShortSummary(array $arguments = [])
    {
        $summaries = [];

        foreach ($arguments as $argument) {
            $summaries[] = "[{$argument->buildSummary()}]";
        }

        return implode(' ', $summaries);
    }

    /**
     * Parse command line options into prefixed CLImate arguments.
     *
     * Prefixed arguments are arguments with a prefix (-) or a long prefix (--)
     * on the command line.
     *
     * Return the arguments passed on the command line that didn't match up with
     * prefixed arguments so they can be assigned to non-prefixed arguments.
     *
     * @param array $argv
     * @return array
     */
    protected function parsePrefixedArguments(array $argv = [])
    {
        foreach ($argv as $key => $cliArgument) {
            list($name, $value) = $this->getNameAndValue($cliArgument);

            $argv = $this->setPrefixedArgumentValue($argv, $key, $name, $value);
        }

        // Send un-parsed arguments back upstream.
        return array_values($argv);
    }

    /**
     * Parse the name and value of the argument passed in
     *
     * @param string $cliArgument
     * @return string[] [$name, $value]
     */
    protected function getNameAndValue($cliArgument)
    {
        // Look for arguments defined in the "key=value" format.
        if (strpos($cliArgument, '=') !== false) {
            return explode('=', $cliArgument, 2);
        }

        // If the argument isn't in "key=value" format then assume it's in
        // "key value" format and define the value after we've found the
        // matching CLImate argument.
        return [$cliArgument, null];
    }

    /**
     * Set the an argument's value and remove applicable
     * arguments from array
     *
     * @param array $argv
     * @param int $key
     * @param string $name
     * @param string|null $value
     *
     * @return array The new $argv
     */
    protected function setPrefixedArgumentValue($argv, $key, $name, $value)
    {
        // Look for the argument in our defined $arguments and assign their
        // value.
        if (!($argument = $this->findPrefixedArgument($name))) {
            return $argv;
        }

        // We found an argument key, so take it out of the array.
        unset($argv[$key]);

        // Arguments are given the value true if they only need to
        // be defined on the command line to be set.
        if ($argument->definedOnly()) {
            $argument->setValue(true);
            return $argv;
        }

        if (is_null($value)) {
            // If the value wasn't previously defined in "key=value"
            // format then define it from the next command argument.
            $argument->setValue($argv[++$key]);
            unset($argv[$key]);
            return $argv;
        }

        $argument->setValue($value);

        return $argv;
    }

    /**
     * Search for argument in defined prefix arguments
     *
     * @param string $name
     *
     * @return Argument|false
     */
    protected function findPrefixedArgument($name)
    {
        foreach ($this->filter->withPrefix() as $argument) {
            if (in_array($name, ["-{$argument->prefix()}", "--{$argument->longPrefix()}"])) {
                return $argument;
            }
        }

        return false;
    }

    /**
     * Parse unset command line options into non-prefixed CLImate arguments.
     *
     * Non-prefixed arguments are parsed after the prefixed arguments on the
     * command line, in the order that they're defined in the script.
     *
     * @param array $unParsedArguments
     */
    protected function parseNonPrefixedArguments(array $unParsedArguments = [])
    {
        foreach ($this->filter->withoutPrefix() as $key => $argument) {
            if (isset($unParsedArguments[$key])) {
                $argument->setValue($unParsedArguments[$key]);
            }
        }
    }

    /**
     * Get the command name.
     *
     * @param array $argv
     *
     * @return array
     */
    protected function getCommand(array $argv = null)
    {
        return $this->getCommandAndArguments($argv)['command'];
    }

    /**
     * Get the passed arguments.
     *
     * @param array $argv
     *
     * @return array
     */
    protected function getArguments(array $argv = null)
    {
        return $this->getCommandAndArguments($argv)['arguments'];
    }

    /**
     * Pull a command name and arguments from $argv.
     *
     * @param array $argv
     * @return array
     */
    protected function getCommandAndArguments(array $argv = null)
    {
        // If no $argv is provided then use the global PHP defined $argv.
        if (is_null($argv)) {
            global $argv;
        }

        $arguments = $argv;
        $command   = array_shift($arguments);

        return compact('arguments', 'command');
    }
}
