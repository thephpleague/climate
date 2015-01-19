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
    protected $definedOnly = false;

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
     * @param string $prefix
     * @param string $longPrefix
     * @param string $description
     * @param bool $required
     * @param bool $definedOnly
     * @param string $castTo
     * @param string $defaultValue
     */
    public function __construct(
        $name,
        $prefix = null,
        $longPrefix = null,
        $description = null,
        $required = false,
        $definedOnly = false,
        $castTo = 'string',
        $defaultValue = null
    ) {
        $this->setName($name);
        $this->setPrefix($prefix);
        $this->setLongPrefix($longPrefix);
        $this->setDescription($description);
        $this->setRequired($required);
        $this->setDefinedOnly($definedOnly);
        $this->setCastTo($castTo);
        $this->setDefaultValue($defaultValue);

        if ($defaultValue) {
            $this->setValue($defaultValue);
        }
    }

    /**
     * Build a new command argument from an array.
     *
     * @param string $name
     * @param array $argument
     * @return Argument
     */
    public static function createFromArray($name, array $argument)
    {
        return new Argument(
            $name,
            isset($argument['prefix']) ? $argument['prefix'] : null,
            isset($argument['longPrefix']) ? $argument['longPrefix'] : null,
            isset($argument['description']) ? $argument['description'] : null,
            isset($argument['required']) ? $argument['required'] : false,
            isset($argument['definedOnly']) ? $argument['definedOnly'] : false,
            isset($argument['castTo']) ? $argument['castTo'] : 'string',
            isset($argument['defaultValue']) ? $argument['defaultValue'] : null
        );
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
    public function definedOnly()
    {
        return $this->definedOnly;
    }

    /**
     * Set whether or not an argument only needs to be defined to have a value.
     *
     * @param bool $definedOnly
     */
    protected function setDefinedOnly($definedOnly)
    {
        $this->setCastTo('bool');
        $this->definedOnly = (bool) $definedOnly;
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
                "An argument may only be cast to the data type 'string', 'int', 'float', or 'bool'."
            );
        }

        $this->castTo = $this->definedOnly() ? 'bool' : $castTo;
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
        switch ($this->castTo) {
            case 'string':
                $value = (string) $value;
                break;
            case 'int':
                $value = (int) $value;
                break;
            case 'float':
                $value = (float) $value;
                break;
            case 'bool':
                $value = (bool) $value;
                break;
        }

        $this->value = $value;
    }

    /**
     * Build an argument's summary for use in a usage statement.
     *
     * For example, "-u username, --user username", "--force", or
     * "-c count (default: 7)".
     *
     * @return string
     */
    public function buildSummary()
    {
        $printedName = false;
        $summary = '';

        // Print the short prefix first.
        if ($this->prefix()) {
            $summary .= "-{$this->prefix()}";

            if (!$this->definedOnly()) {
                $summary .= " {$this->name()}";
                $printedName = true;
            }
        }

        // Separate the short prefix and the long prefix.
        if ($this->prefix() && $this->longPrefix()) {
            $summary .= ', ';
        }

        // Print the long prefix.
        if ($this->longPrefix()) {
            $summary .= "--{$this->longPrefix()}";

            if (!$this->definedOnly()) {
                $summary .= " {$this->name()}";
                $printedName = true;
            }
        }

        // Print the argument name if it's not printed yet.
        if (!$printedName && !$this->definedOnly()) {
            $summary .= $this->name();
        }

        if ($this->defaultValue()) {
            $summary .= " (default: {$this->defaultValue()})";
        }

        return $summary;
    }

    /**
     * Compare two arguments by their short and long prefixes.
     *
     * @see usort()
     * @param Argument $a
     * @param Argument $b
     * @return int
     */
    public static function compareByPrefix(Argument $a, Argument $b)
    {
        $compareABy = '';
        $compareBBy = '';

        if ($a->longPrefix()) {
            $compareABy = $a->longPrefix();
        }

        if ($a->prefix()) {
            $compareABy = $a->prefix();
        }

        if ($b->longPrefix()) {
            $compareBBy = $b->longPrefix();
        }

        if ($b->prefix()) {
            $compareBBy = $b->prefix();
        }

        return (strtolower($compareABy) < strtolower($compareBBy)) ? -1 : 1;
    }
}
