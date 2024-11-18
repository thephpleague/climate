<?php

namespace League\CLImate\Argument;

use League\CLImate\Exceptions\InvalidArgumentException;

class Parser
{
    /**
     * Filter class to find various types of arguments
     *
     * @var \League\CLImate\Argument\Filter $filter
     */
    protected $filter;

    /**
     * Summary builder class
     *
     * @var \League\CLImate\Argument\Summary $summary
     */
    protected $summary;

    protected $trailing;

    protected $trailingArray;

    /**
     * List of unknown arguments and best argument suggestion.
     *
     * The key corresponds to the unknown argument and the value to the
     * argument suggestion, if any.
     *
     * @var array
     */
    protected $unknowPrefixedArguments = [];

    /**
     * Minimum similarity percentage to detect similar arguments.
     *
     * @var float
     */
    protected $minimumSimilarityPercentage = 0.6;

    public function __construct()
    {
        $this->summary = new Summary();
    }

    /**
     * @param Filter $filter
     * @param Argument[] $arguments
     *
     * @return \League\CLImate\Argument\Parser
     */
    public function setFilter($filter, $arguments)
    {
        $this->filter = $filter;
        $this->filter->setArguments($arguments);

        return $this;
    }

    /**
     * Parse command line arguments into CLImate arguments.
     *
     * @param array $argv
     *
     * @return void
     * @throws InvalidArgumentException if required arguments aren't defined.
     */
    public function parse(?array $argv = null)
    {
        $cliArguments = $this->arguments($argv);

        if (in_array('--', $cliArguments)) {
            $cliArguments = $this->removeTrailingArguments($cliArguments);
        }

        $unParsedArguments = $this->prefixedArguments($cliArguments);

        // Searches for unknown prefixed arguments and finds a suggestion
        // within the list of valid arguments.
        $this->unknowPrefixedArguments($unParsedArguments);

        $this->nonPrefixedArguments($unParsedArguments);

        // After parsing find out which arguments were required but not
        // defined on the command line.
        $missingArguments = $this->filter->missing();

        if (count($missingArguments) > 0) {
            throw new InvalidArgumentException(
                'The following arguments are required: '
                . $this->summary->short($missingArguments) . '.'
            );
        }
    }

    /**
     * Get the command name.
     *
     * @param array $argv
     *
     * @return string
     */
    public function command(?array $argv = null)
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
    public function arguments(?array $argv = null)
    {
        return $this->getCommandAndArguments($argv)['arguments'];
    }

    /**
     * Get the trailing arguments
     *
     * @return string|null
     */
    public function trailing()
    {
        return $this->trailing;
    }

    /**
     * Get the trailing arguments as an array
     *
     * @return array|null
     */
    public function trailingArray()
    {
        return $this->trailingArray;
    }

    /**
     * Remove the trailing arguments from the parser and set them aside
     *
     * @param array $arguments
     *
     * @return array
     */
    protected function removeTrailingArguments(array $arguments)
    {
        $trailing = array_splice($arguments, array_search('--', $arguments));
        array_shift($trailing);
        $this->trailingArray = $trailing;
        $this->trailing = implode(' ', $trailing);

        return $arguments;
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
    protected function prefixedArguments(array $argv = [])
    {
        foreach ($argv as $key => $passed_argument) {
            $argv = $this->trySettingArgumentValue($argv, $key, $passed_argument);
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
    protected function nonPrefixedArguments(array $unParsedArguments = [])
    {
        foreach ($this->filter->withoutPrefix() as $key => $argument) {
            if (isset($unParsedArguments[$key])) {
                $argument->setValue($unParsedArguments[$key]);
            }
        }
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
     * Attempt to set the an argument's value and remove applicable
     * arguments from array
     *
     * @param array $argv
     * @param int $key
     * @param string $passed_argument
     *
     * @return array The new $argv
     */
    protected function trySettingArgumentValue($argv, $key, $passed_argument)
    {
        list($name, $value) = $this->getNameAndValue($passed_argument);

        // Look for the argument in our defined $arguments
        // and assign their value.
        if (!($argument = $this->findPrefixedArgument($name))) {
            return $argv;
        }

        // We found an argument key, so take it out of the array.
        unset($argv[$key]);

        return $this->setArgumentValue($argv, $argument, $key, $value);
    }

    /**
     * Set the argument's value
     *
     * @param array $argv
     * @param Argument $argument
     * @param int $key
     * @param string|null $value
     *
     * @return array The new $argv
     */
    protected function setArgumentValue($argv, $argument, $key, $value)
    {
        // Arguments are given the value true if they only need to
        // be defined on the command line to be set.
        if ($argument->noValue()) {
            $argument->setValue(true);
            return $argv;
        }

        if (is_null($value)) {
            if (count($argv) === 0) {
                return $argv;
            }

            // If the value wasn't previously defined in "key=value"
            // format then define it from the next command argument.
            $nextArgvValue = $argv[$key + 1];
            if ($this->isValidArgumentValue($nextArgvValue)) {
                $argument->setValue($nextArgvValue);
                unset($argv[$key + 1]);
                return $argv;
            }
        }

        $argument->setValue($value);

        return $argv;
    }

    /**
     * Check if the value is considered a valid input value.
     *
     * @param $argumentValue
     * @return bool
     */
    protected function isValidArgumentValue($argumentValue)
    {
        return empty($this->findPrefixedArgument($argumentValue));
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
     * Pull a command name and arguments from $argv.
     *
     * @param array $argv
     * @return array
     */
    protected function getCommandAndArguments(?array $argv = null)
    {
        // If no $argv is provided then use the global PHP defined $argv.
        if (is_null($argv)) {
            global $argv;
        }

        $arguments = $argv;
        $command   = array_shift($arguments);

        return compact('arguments', 'command');
    }

    /**
     * Processes unknown prefixed arguments and sets suggestions if no matching
     * prefix is found.
     *
     * @param array $unParsedArguments The array of unparsed arguments to
     * process.
     */
    protected function unknowPrefixedArguments(array $unParsedArguments)
    {
        foreach ($unParsedArguments as $arg) {
            $unknowArgumentName = $this->getUnknowArgumentName($arg);
            if (!$this->findPrefixedArgument($unknowArgumentName)) {
                if (is_null($unknowArgumentName)) {
                    continue;
                }
                $suggestion = $this->findSuggestionsForUnknowPrefixedArguments(
                    $unknowArgumentName,
                    $this->filter->withPrefix()
                );
                $this->setSuggestion($unknowArgumentName, $suggestion);
            }
        }
    }

    /**
     * Sets the suggestion for an unknown argument name.
     *
     * @param string $unknowArgName The name of the unknown argument.
     * @param string $suggestion The suggestion for the unknown argument.
     */
    protected function setSuggestion(string $unknowArgName, string $suggestion)
    {
        $this->unknowPrefixedArguments[$unknowArgName] = $suggestion;
    }

    /**
     * Extracts the unknown argument name from a given argument string.
     *
     * @param string $arg The argument string to process.
     * @return string|null The extracted unknown argument name or null if not
     * found.
     */
    protected function getUnknowArgumentName(string $arg)
    {
        if (preg_match('/^[-]{1,2}([^-]+?)(?:=|$)/', $arg, $matches)) {
            return $matches[1];
        }
        return null;
    }

    /**
     * Finds the most similar known argument for an unknown prefixed argument.
     *
     * @param string $argName The name of the unknown argument to find
     * suggestions for.
     * @param array $argList The list of known arguments to compare against.
     * @return string The most similar known argument name.
     */
    protected function findSuggestionsForUnknowPrefixedArguments(
        string $argName,
        array $argList
    ) {
        $mostSimilar = '';
        $greatestSimilarity = $this->minimumSimilarityPercentage * 100;
        foreach ($argList as $arg) {
            similar_text($argName, $arg->name(), $percent);
            if ($percent > $greatestSimilarity) {
                $greatestSimilarity = $percent;
                $mostSimilar = $arg->name();
            }
        }
        return $mostSimilar;
    }

    /**
     * Returns the list of unknown prefixed arguments and their suggestions.
     *
     * @return array The list of unknown prefixed arguments and their suggestions.
     */
    public function getUnknowPrefixedArgumentsAndSuggestions()
    {
        return $this->unknowPrefixedArguments;
    }

    /**
     * Sets the minimum similarity percentage for finding suggestions.
     *
     * @param float $percentage The minimum similarity percentage to set.
     */
    public function setMinimumSimilarityPercentage(float $percentage)
    {
        $this->minimumSimilarityPercentage = $percentage;
    }
}
