<?php

namespace League\CLImate\Argument;

class Filter
{
    protected $arguments = [];

    /**
     * Set the available arguments
     *
     * @param array $arguments
     */
    public function setArguments(array $arguments)
    {
        $this->arguments = $arguments;
    }

    /**
     * Retrieve optional arguments
     *
     * @return Argument[]
     */
    public function optional()
    {
        return $this->filterArguments(['isOptional']);
    }

    /**
     * Retrieve required arguments
     *
     * @return Argument[]
     */
    public function required()
    {
        return $this->filterArguments(['isRequired']);
    }

    /**
     * Retrieve arguments with prefix
     *
     * @return Argument[]
     */
    public function withPrefix()
    {
        return $this->filterArguments(['hasPrefix']);
    }

    /**
     * Retrieve arguments without prefix
     *
     * @return Argument[]
     */
    public function withoutPrefix()
    {
        return $this->filterArguments(['noPrefix']);
    }

    /**
     * Find all required arguments that don't have values after parsing.
     *
     * These arguments weren't defined on the command line.
     *
     * @return Argument[]
     */
    public function missing()
    {
        return $this->filterArguments(['isRequired', 'noValue']);
    }

    /**
     * Filter defined arguments as to whether they are required or not
     *
     * @param string[] $filters
     *
     * @return Argument[]
     */
    protected function filterArguments($filters = [])
    {
        $arguments = $this->arguments;

        foreach ($filters as $filter) {
            $arguments = array_filter($arguments, [$this, $filter]);
        }

        if (in_array('hasPrefix', $filters)) {
            usort($arguments, [$this, 'compareByPrefix']);
        }

        return array_values($arguments);
    }

    /**
     * Determine whether an argument as a prefix
     *
     * @param Argument $argument
     *
     * @return bool
     */
    protected function noPrefix($argument)
    {
        return !$argument->hasPrefix();
    }

    /**
     * Determine whether an argument as a prefix
     *
     * @param Argument $argument
     *
     * @return bool
     */
    protected function hasPrefix($argument)
    {
        return $argument->hasPrefix();
    }

    /**
     * Determine whether an argument is required
     *
     * @param Argument $argument
     *
     * @return bool
     */
    protected function isRequired($argument)
    {
        return $argument->isRequired();
    }

    /**
     * Determine whether an argument is optional
     *
     * @param Argument $argument
     *
     * @return bool
     */
    protected function isOptional($argument)
    {
        return !$argument->isRequired();
    }

    /**
     * Determine whether an argument is optional
     *
     * @param Argument $argument
     *
     * @return bool
     */
    protected function noValue($argument)
    {
        return $argument->values() == [];
    }

    /**
     * Compare two arguments by their short and long prefixes.
     *
     * @see usort()
     *
     * @param Argument $a
     * @param Argument $b
     *
     * @return int
     */
    public function compareByPrefix(Argument $a, Argument $b)
    {
        if ($this->prefixCompareString($a) < $this->prefixCompareString($b)) {
            return -1;
        }

        return 1;
    }

    /**
     * Prep the prefix string for comparison
     *
     * @param Argument $argument
     *
     * @return string
     */
    protected function prefixCompareString(Argument $argument)
    {
        return mb_strtolower($argument->longPrefix() ?: $argument->prefix() ?: '');
    }
}
