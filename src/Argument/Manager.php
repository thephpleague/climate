<?php

namespace League\CLImate\Argument;

use League\CLImate\CLImate;

class Manager implements ManagerInterface
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
     * @var FilterInterface $filter
     */
    protected $filter;

    /**
     * Summary builder class
     *
     * @var SummaryInterface $summary
     */
    protected $summary;

    /**
     * Argument parser class
     *
     * @var ParserInterface $parser
     */
    protected $parser;

    /**
     * Argument creator class name
     *
     * @var ArgumentInterface $creator
     */
    protected $creator;

    /**
     * @param FilterInterface $filter
     * @param SummaryInterface $summary
     * @param ParserInterface $parser
     * @param string $creator
     */
    public function __construct(FilterInterface $filter = null, SummaryInterface $summary = null, ParserInterface $parser = null, $creator = null)
    {
        $this->filter  = $filter ?: new Filter();
        $this->summary = $summary ?: new Summary();
        $this->parser  = $parser ?: new Parser();
        $this->creator = $creator ?: Argument::class;
        $reflection = new \ReflectionClass($this->creator);
        $implementsInterface = $reflection->implementsInterface(ArgumentInterface::class);
        if ($implementsInterface) {
            $this->creator = $reflection->newInstanceWithoutConstructor();
        } else {
            throw new \InvalidArgumentException(sprintf(
                'The given argument "%s" must be implements "%s".',
                $this->creator,
                ArgumentInterface::class
            ));
        }
    }

    /**
     * {@inheritdoc}
     */
    public function add($argument, array $options = [])
    {
        if (is_array($argument)) {
            $this->addMany($argument);
            return;
        }

        if (is_string($argument)) {
            $argument = $this->creator->createFromArray($argument, $options);
        }

        if (!($argument instanceof ArgumentInterface)) {
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
     * {@inheritdoc}
     */
    public function exists($name)
    {
        return isset($this->arguments[$name]);
    }

    /**
     * {@inheritdoc}
     */
    public function get($name)
    {
        return isset($this->arguments[$name]) ? $this->arguments[$name]->value() : null;
    }

    /**
     * {@inheritdoc}
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
     * {@inheritdoc}
     */
    public function description($description)
    {
        $this->description = trim($description);
    }

    /**
     * {@inheritdoc}
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
