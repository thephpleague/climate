<?php

namespace League\CLImate\Argument;

class Filter {

    /**
     * Determine whether an argument as a prefix
     *
     * @param Argument $argument
     *
     * @return bool
     */
    public function noPrefix($argument)
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
    public function hasPrefix($argument)
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
    public function isRequired($argument)
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
    public function isOptional($argument)
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
    public function noValue($argument)
    {
        return is_null($argument->value());
    }

}
