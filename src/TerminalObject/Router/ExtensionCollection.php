<?php

namespace League\CLImate\TerminalObject\Router;

use League\CLImate\Exceptions\InvalidArgumentException;
use League\CLImate\Exceptions\UnexpectedValueException;
use League\CLImate\Util\Helper;

class ExtensionCollection
{
    /**
     * @var array collection
     */
    protected $collection = ['basic' => [], 'dynamic' => []];

    /**
     * @var string $basic_interface
     */
    protected $basic_interface = 'League\CLImate\TerminalObject\Basic\BasicTerminalObjectInterface';

    /**
     * @var string $dynamic_interface
     */
    protected $dynamic_interface = 'League\CLImate\TerminalObject\Dynamic\DynamicTerminalObjectInterface';

    public function __construct($key, $class)
    {
        $this->createCollection($key, $class);
    }

    public function collection()
    {
        return $this->collection;
    }

    /**
     * Create the collection from the key/class
     *
     * @param string $original_key
     * @param string|object|array $original_class
     *
     * @return void
     */
    protected function createCollection($original_key, $original_class)
    {
        $collection = $this->convertToArray($original_key, $original_class);

        foreach ($collection as $key => $class) {
            $this->validateExtension($class);
            $this->collection[$this->getType($class)][$this->getKey($key, $class)] = $class;
        }
    }

    /**
     * Convert the given class and key to an array of classes
     *
     * @param string|object|array $class
     * @param string $key Optional custom key instead of class name
     *
     * @return array
     */
    protected function convertToArray($key, $class)
    {
        if (is_array($class)) {
            return $class;
        }

        return [$this->getKey($key, $class) => $class];
    }

    /**
     * Ensure that the extension is valid
     *
     * @param string|object|array $class
     */
    protected function validateExtension($class)
    {
        $this->validateClassExists($class);
        $this->validateClassImplementation($class);
    }

    /**
     * @param string|object $class
     *
     * @throws UnexpectedValueException if extension class does not exist
     */
    protected function validateClassExists($class)
    {
        if (is_string($class) && !class_exists($class)) {
            throw new UnexpectedValueException('Class does not exist: ' . $class);
        }
    }

    /**
     * @param string|object $class
     *
     * @throws InvalidArgumentException if extension class does not implement either Dynamic or Basic interface
     */
    protected function validateClassImplementation($class)
    {
        $str_class = is_string($class);

        $valid_implementation = (is_a($class, $this->basic_interface, $str_class)
                                    || is_a($class, $this->dynamic_interface, $str_class));

        if (!$valid_implementation) {
            throw new InvalidArgumentException('Class must implement either '
                                    . $this->basic_interface . ' or ' . $this->dynamic_interface);
        }
    }

    /**
     * Determine the extension key based on the class
     *
     * @param string|null $key
     * @param string|object $class
     *
     * @return string
     */
    protected function getKey($key, $class)
    {
        if ($key === null || !is_string($key)) {
            $class_path = (is_string($class)) ? $class : get_class($class);

            $key = explode('\\', $class_path);
            $key = end($key);
        }

        return Helper::snakeCase($key);
    }

    /**
     * Get the type of class the extension implements
     *
     * @param string|object $class
     *
     * @return string 'basic' or 'dynamic'
     */
    protected function getType($class)
    {
        if (is_a($class, $this->basic_interface, is_string($class))) {
            return 'basic';
        }

        return 'dynamic';
    }
}
