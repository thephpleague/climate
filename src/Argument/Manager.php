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
     * @var string
     */
    protected $description;

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
     * @return bool
     */
    public function defined($name, array $argv = null)
    {
        // The argument isn't defined if it's not defined by the calling code.
        if (!$this->exists($name)) {
            return false;
        }

        $argument = $this->arguments[$name];
        $commandArguments = $this->getCommandAndArguments($argv)['arguments'];

        foreach ($commandArguments as $commandArgument) {
            if ($argument->prefix() && strpos($commandArgument, "-{$argument->prefix()}") === 0) {
                return true;
            }

            if ($argument->longPrefix() && strpos($commandArgument, "--{$argument->longPrefix()}") === 0) {
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
        $command = $this->getCommandAndArguments($argv)['command'];
        $required = $this->findRequired();
        $optional = $this->findRequired(false);
        $withPrefix = $this->findWithPrefix();
        $withoutPrefix = $this->findWithPrefix(false);

        // Print the description if it's defined.
        if ($this->description) {
            $climate->out($this->description);
            $climate->br();
        }

        // Print the usage statement with the arguments without a prefix at the
        // end.
        $climate->out(
            "Usage: {$command} " . $this->buildShortSummary(array_merge($withPrefix, $withoutPrefix))
        );

        // Print required argument details.
        if (count($required) > 0) {
            $climate->br();
            $climate->out("Required Arguments:");

            foreach ($required as $argument) {
                $climate->tab()->out($argument->buildSummary());

                if ($argument->description()) {
                    $climate->tab(2)->out($argument->description());
                }
            }
        }

        // Print optional argument details.
        if (count($optional) > 0) {
            $climate->br();
            $climate->out("Optional Arguments:");

            foreach ($optional as $argument) {
                $climate->tab()->out($argument->buildSummary());

                if ($argument->description()) {
                    $climate->tab(2)->out($argument->description());
                }
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
        $cliArguments = $this->getCommandAndArguments($argv)['arguments'];
        $unParsedArguments = $this->parsePrefixedArguments($cliArguments);
        $this->parseNonPrefixedArguments($unParsedArguments);

        // After parsing find out which arguments were required but not defined
        // on the command line.
        $missingArguments = $this->findMissing();

        if (count($missingArguments) > 0) {
            throw new \Exception(
                'The following arguments are required: ' . $this->buildShortSummary($missingArguments) . '.'
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
            // Look for arguments defined in the "key=value" format.
            if (strpos($cliArgument, '=') !== false) {
                list ($name, $value) = explode('=', $cliArgument, 2);

                // If the argument isn't in "key=value" format then assume it's in
                // "key value" format and define the value after we've found the
                // matching CLImate argument.
            } else {
                $name = $cliArgument;
                $value = null;
            }

            // Look for the argument in our defined $arguments and assign their
            // value.
            foreach ($this->findWithPrefix() as $argument) {
                if (in_array($name, ["-{$argument->prefix()}", "--{$argument->longPrefix()}"])) {
                    // We found an argument key, so take it out of the array.
                    unset($argv[$key]);

                    // Arguments are given the value true if they only need to
                    // be defined on the command line to be set.
                    if ($argument->definedOnly()) {
                        $value = true;
                    } elseif (is_null($value)) {
                        // If the value wasn't previously defined in "key=value"
                        // format then define it from the next command argument.
                        $value = $argv[$key + 1];
                        unset($argv[$key + 1]);
                    }

                    $argument->setValue($value);
                }
            }
        }

        // Send un-parsed arguments back upstream.
        return array_values($argv);
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
        foreach ($this->findWithPrefix(false) as $key => $argument) {
            if (isset($unParsedArguments[$key])) {
                $argument->setValue($unParsedArguments[$key]);
            }
        }
    }

    /**
     * Retrieve all required arguments.
     *
     * If $required is false then retrieve optional arguments instead.
     *
     * @param bool $required
     * @param bool $hasPrefix
     * @return Argument[]
     */
    protected function findRequired($required = true, $hasPrefix = true)
    {
        $arguments = [];

        foreach ($this->all() as $argument) {
            if (
                (($required && $argument->isRequired()) || (!$required && !$argument->isRequired()))
                && (($hasPrefix && $argument->hasPrefix()) || (!$hasPrefix && !$argument->hasPrefix()))
            ) {
                $arguments[] = $argument;
            }
        }

        usort($arguments, ['League\CLImate\Argument\Argument', 'compareByPrefix']);

        return $arguments;
    }

    /**
     * Retrieve all arguments with either short or long prefixes defined.
     *
     * If $withPrefix is false then retrieve arguments with no prefix defined.
     *
     * @param bool $withPrefix
     * @return Argument[]
     */
    public function findWithPrefix($withPrefix = true)
    {
        $arguments = [];

        foreach ($this->all() as $argument) {
            if (
                ($withPrefix && $argument->hasPrefix())
                || (!$withPrefix && !$argument->hasPrefix())
            ) {
                $arguments[] = $argument;
            }
        }

        if ($withPrefix) {
            usort($arguments, ['League\CLImate\Argument\Argument', 'compareByPrefix']);
        }

        return $arguments;
    }

    /**
     * Find all required arguments that don't have values after parsing.
     *
     * These arguments weren't defined on the command line.
     *
     * @return Argument[]
     */
    protected function findMissing()
    {
        $missingArguments = [];

        foreach ($this->all() as $argument) {
            if ($argument->isRequired() && is_null($argument->value())) {
                $missingArguments[] = $argument;
            }
        }

        return $missingArguments;
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
        $command = array_shift($arguments);

        return [
            'command' => $command,
            'arguments' => $arguments,
        ];
    }
}
