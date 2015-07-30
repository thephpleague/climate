<?php

namespace League\CLImate\Argument;

use League\CLImate\CLImate;

class Summary
{
    /**
     * @var \League\CLImate\CLImate $climate
     */
    protected $climate;

    /**
     * @var string $description
     */
    protected $description;

    /**
     * @var string $command
     */
    protected $command;

    /**
     * @var Filter $filter
     */
    protected $filter;

    /**
     * @param \League\CLImate\CLImate $climate
     *
     * @return \League\CLImate\Argument\Summary
     */
    public function setClimate(CLImate $climate)
    {
        $this->climate = $climate;

        return $this;
    }

    /**
     * @param string $description
     *
     * @return \League\CLImate\Argument\Summary
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @param string $command
     *
     * @return \League\CLImate\Argument\Summary
     */
    public function setCommand($command)
    {
        $this->command = $command;

        return $this;
    }

    /**
     * @param Filter $filter
     * @param Argument[] $arguments
     *
     * @return \League\CLImate\Argument\Summary
     */
    public function setFilter($filter, $arguments)
    {
        $this->filter = $filter;
        $this->filter->setArguments($arguments);

        return $this;
    }

    /**
     * Output the full summary for the program
     */
    public function output()
    {
        // Print the description if it's defined.
        if ($this->description) {
            $this->climate->out($this->description)->br();
        }

        // Print the usage statement with the arguments without a prefix at the end.
        $this->climate->out("Usage: {$this->command} "
                            . $this->short($this->getOrderedArguments()));

        // Print argument details.
        foreach (['required', 'optional'] as $type) {
            $this->outputArguments($this->filter->{$type}(), $type);
        }
    }

    /**
     * Build a short summary of a list of arguments.
     *
     * @param Argument[] $arguments
     *
     * @return string
     */
    public function short($arguments)
    {
        return implode(' ', array_map([$this, 'argumentBracketed'], $arguments));
    }

    /**
     * Build an argument's summary for use in a usage statement.
     *
     * For example, "-u username, --user username", "--force", or
     * "-c count (default: 7)".
     *
     * @param Argument $argument
     *
     * @return string
     */
    public function argument(Argument $argument)
    {
        $summary     = $this->prefixedArguments($argument);
        $printedName = strstr($summary, ' ' . $argument->name());

        // Print the argument name if it's not printed yet.
        if (!$printedName && !$argument->noValue()) {
            $summary .= $argument->name();
        }

        if ($argument->defaultValue()) {
            $summary .= " (default: {$argument->defaultValue()})";
        }

        return $summary;
    }

    /**
     * Build argument summary surrounded by brackets
     *
     * @param Argument $argument
     *
     * @return string
     */
    protected function argumentBracketed(Argument $argument)
    {
        return '[' . $this->argument($argument) . ']';
    }

    /**
     * Get the arguments ordered by whether or not they have a prefix
     *
     * @return Argument[]
     */
    protected function getOrderedArguments()
    {
        return array_merge($this->filter->withPrefix(), $this->filter->withoutPrefix());
    }

    /**
     * Print out the argument list
     *
     * @param array $arguments
     * @param string $type
     */
    protected function outputArguments($arguments, $type)
    {
        if (count($arguments) == 0) {
            return;
        }

        $this->climate->br()->out(ucwords($type) . ' Arguments:');

        foreach ($arguments as $argument) {
            $this->climate->tab()->out($this->argument($argument));

            if ($argument->description()) {
                $this->climate->tab(2)->out($argument->description());
            }
        }
    }

    /**
     * Builds the summary for any prefixed arguments
     *
     * @param Argument $argument
     *
     * @return string
     */
    protected function prefixedArguments(Argument $argument)
    {
        $prefixes = [$argument->prefix(), $argument->longPrefix()];
        $summary  = [];

        foreach ($prefixes as $key => $prefix) {
            if (!$prefix) {
                continue;
            }

            $sub = str_repeat('-', $key + 1) . $prefix;

            if (!$argument->noValue()) {
                $sub .= " {$argument->name()}";
            }

            $summary[] = $sub;
        }

        return implode(', ', $summary);
    }
}
