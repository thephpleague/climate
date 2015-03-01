<?php

namespace League\CLImate\Argument;

class Argument
{
    /**
     * An argument's name.
     *
     * Use this name when internally referring to the argument.
     *
     * @var string
     */
    protected $name;

    /**
     * An argument's short representation.
     *
     * @var string
     */
    protected $prefix;

    /**
     * An argument's long representation.
     *
     * @var string
     */
    protected $longPrefix;

    /**
     * An argument's description.
     *
     * @var string
     */
    protected $description;

    /**
     * Whether or not an argument is required.
     *
     * @var bool
     */
    protected $required = false;

    /**
     * Whether or not an argument only needs to be defined to have a value.
     *
     * These arguments have the value true when they are defined on the command
     * line.
     *
     * @var bool
     */
    protected $noValue = false;

    /**
     * Which data type to cast an argument's value to.
     *
     * Valid data types are "string", "int", "float", and "bool".
     *
     * @var string
     */
    protected $castTo = 'string';

    /**
     * An argument's default value.
     *
     * @var string
     */
    protected $defaultValue;

    /**
     * An argument's value, after type casting.
     *
     * @var string|int|float|bool
     */
    protected $value;

    /**
     * Build a new command argument.
     *
     * @param string $name
     */
    public function __construct($name)
    {
        $this->setName($name);
    }

    /**
     * Build a new command argument from an array.
     *
     * @param string $name
     * @param array $params
     *
     * @return Argument
     */
    public static function createFromArray($name, array $params)
    {
        $argument = new Argument($name);
        $params   = self::getSettableArgumentParams($params);

        foreach ($params as $key => $value) {
            $method = 'set' . ucwords($key);
            $argument->{$method}($value);
        }

        if ($argument->defaultValue()) {
            $argument->setValue($argument->defaultValue());
        }

        return $argument;
    }

    /**
     * Get argument params based on settable properties
     *
     * @param array $params
     *
     * @return array
     */
    protected static function getSettableArgumentParams(array $params)
    {
        $allowed = [
                    'prefix',
                    'longPrefix',
                    'description',
                    'required',
                    'noValue',
                    'castTo',
                    'defaultValue',
                ];

        return array_intersect_key($params, array_flip($allowed));
    }

    /**
     * Retrieve an argument's name.
     *
     * Use this name when internally referring to the argument.
     *
     * @return string
     */
    public function name()
    {
        return $this->name;
    }

    /**
     * Set an argument's name.
     *
     * Use this name when internally referring to the argument.
     *
     * @param string $name
     */
    protected function setName($name)
    {
        $this->name = trim($name);
    }

    /**
     * Retrieve an argument's short form.
     *
     * @return string
     */
    public function prefix()
    {
        return $this->prefix;
    }

    /**
     * Set an argument's short form.
     *
     * @param string $prefix
     */
    protected function setPrefix($prefix)
    {
        $this->prefix = trim($prefix);
    }

    /**
     * Retrieve an argument's long form.
     *
     * @return string
     */
    public function longPrefix()
    {
        return $this->longPrefix;
    }

    /**
     * Set an argument's short form.
     *
     * @param string $longPrefix
     */
    protected function setLongPrefix($longPrefix)
    {
        $this->longPrefix = trim($longPrefix);
    }

    /**
     * Determine if an argument has a prefix.
     *
     * @return bool
     */
    public function hasPrefix()
    {
        return $this->prefix() || $this->longPrefix();
    }

    /**
     * Retrieve an argument's description.
     *
     * @return string
     */
    public function description()
    {
        return $this->description;
    }

    /**
     * Set an argument's description.
     *
     * @param string $description
     */
    protected function setDescription($description)
    {
        $this->description = trim($description);
    }

    /**
     * Determine whether or not an argument is required.
     *
     * @return bool
     */
    public function isRequired()
    {
        return $this->required;
    }

    /**
     * Set whether an argument is required or not.
     *
     * @param bool $required
     */
    protected function setRequired($required)
    {
        $this->required = (bool) $required;
    }

    /**
     * Determine whether or not an argument only needs to be defined to have a
     * value.
     *
     * @return bool
     */
    public function noValue()
    {
        return $this->noValue;
    }

    /**
     * Set whether or not an argument only needs to be defined to have a value.
     *
     * @param bool $noValue
     */
    protected function setNoValue($noValue)
    {
        $this->setCastTo('bool');
        $this->noValue = (bool) $noValue;
    }

    /**
     * Retrieve the data type to cast an argument's value to.
     *
     * @return string
     */
    public function castTo()
    {
        return $this->castTo;
    }

    /**
     * Set the data type to cast an argument's value to.
     *
     * Valid data types are "string", "int", "float", and "bool".
     *
     * @throws \Exception if $castTo is not a valid data type.
     * @param string $castTo
     */
    protected function setCastTo($castTo)
    {
        if (!in_array($castTo, ['string', 'int', 'float', 'bool'])) {
            throw new \Exception(
                "An argument may only be cast to the data type "
                . "'string', 'int', 'float', or 'bool'."
            );
        }

        $this->castTo = $this->noValue() ? 'bool' : $castTo;
    }

    /**
     * Retrieve an argument's default value.
     *
     * @return string
     */
    public function defaultValue()
    {
        return $this->defaultValue;
    }

    /**
     * Set an argument's default value.
     *
     * @param string $defaultValue
     */
    public function setDefaultValue($defaultValue)
    {
        $this->defaultValue = $defaultValue;
    }

    /**
     * Retrieve an argument's value.
     *
     * Argument values are type cast based on the value of $castTo.
     *
     * @return string|int|float|bool
     */
    public function value()
    {
        return $this->value;
    }

    /**
     * Set an argument's value based on its command line entry.
     *
     * Argument values are type cast based on the value of $castTo.
     *
     * @param string|bool $value
     */
    public function setValue($value)
    {
        $cast_method = 'castTo' . ucwords($this->castTo);
        $this->value = $this->{$cast_method}($value);
    }

    /**
     * @param string $value
     *
     * @return string
     */
    protected function castToString($value)
    {
        return (string) $value;
    }

    /**
     * @param string $value
     *
     * @return int
     */
    protected function castToInt($value)
    {
        return (int) $value;
    }

    /**
     * @param string $value
     *
     * @return float
     */
    protected function castToFloat($value)
    {
        return (float) $value;
    }

    /**
     * @param string $value
     *
     * @return bool
     */
    protected function castToBool($value)
    {
        return (bool) $value;
    }
}
