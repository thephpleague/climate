<?php

namespace League\CLImate;

use Psr\Log\AbstractLogger;
use Psr\Log\InvalidArgumentException;
use Psr\Log\LogLevel;
use function array_key_exists;
use function is_array;
use function str_replace;
use function strpos;

/**
 * A PSR-3 compatible logger that uses CLImate for output.
 */
class Logger extends AbstractLogger
{
    /**
     * @var array $levels Conversion of the level strings to their numeric representations.
     */
    private $levels = [
        LogLevel::EMERGENCY => 1,
        LogLevel::ALERT => 2,
        LogLevel::CRITICAL => 3,
        LogLevel::ERROR => 4,
        LogLevel::WARNING => 5,
        LogLevel::NOTICE => 6,
        LogLevel::INFO => 7,
        LogLevel::DEBUG => 8,
    ];

    /**
     * @var int $level Ignore logging attempts at a level less than this.
     */
    private $level;

    /**
     * @var CLImate $climate The underlying climate instance we are using for output.
     */
    private $climate;

    /**
     * Create a new Logger instance.
     *
     * @param string $level One of the LogLevel constants
     * @param CLImate $climate An existing CLImate instance to use for output
     */
    public function __construct($level = LogLevel::INFO, CLImate $climate = null)
    {
        $this->level = $this->convertLevel($level);

        if ($climate === null) {
            $climate = new CLImate;
        }
        $this->climate = $climate;

        # Define some default styles to use for the output
        $commands = [
            "emergency" => ["white", "bold", "background_red"],
            "alert" => ["white", "background_yellow"],
            "critical" => ["red", "bold"],
            "error" => ["red"],
            "warning" => "yellow",
            "notice" => "light_cyan",
            "info" => "green",
            "debug" => "dark_gray",
        ];

        # If any of the required styles are not defined then define them now
        foreach ($commands as $command => $style) {
            if (!$this->climate->style->get($command)) {
                $this->climate->style->addCommand($command, $style);
            }
        }
    }


    /**
     * Get a numeric log level for the passed parameter.
     *
     * @param string $level One of the LogLevel constants
     *
     * @return int
     */
    private function convertLevel($level)
    {
        # If this is one of the defined string log levels then return it's numeric value
        if (!array_key_exists($level, $this->levels)) {
            throw new InvalidArgumentException("Unknown log level: {$level}");
        }

        return $this->levels[$level];
    }


    /**
     * Get a new instance logging at a different level
     *
     * @param string $level One of the LogLevel constants
     *
     * @return Logger
     */
    public function withLogLevel($level)
    {
        $logger = clone $this;
        $logger->level = $this->convertLevel($level);
        return $logger;
    }


    /**
     * Log messages to a CLImate instance.
     *
     * @param string $level One of the LogLevel constants
     * @param string|object $message If an object is passed it must implement __toString()
     * @param array $context Placeholders to be substituted in the message
     *
     * @return void
     */
    public function log($level, $message, array $context = []): void
    {
        if ($this->convertLevel($level) > $this->level) {
            return;
        }

        # Handle objects implementing __toString
        $message = (string)$message;

        # Handle any placeholders in the $context array
        foreach ($context as $key => $val) {
            $placeholder = "{" . $key . "}";

            # If this context key is used as a placeholder, then replace it, and remove it from the $context array
            if (strpos($message, $placeholder) !== false) {
                $val = (string)$val;
                $message = str_replace($placeholder, $val, $message);
                unset($context[$key]);
            }
        }

        # Send the message to the climate instance
        $this->climate->{$level}($message);

        # Append any context information not used as placeholders
        $this->outputRecursiveContext($level, $context, 1);
    }


    /**
     * Handle recursive arrays in the logging context.
     *
     * @param string $level One of the LogLevel constants
     * @param array $context The array of context to output
     * @param int $indent The current level of indentation to be used
     *
     * @return void
     */
    private function outputRecursiveContext($level, array $context, $indent)
    {
        foreach ($context as $key => $val) {
            $this->climate->tab($indent);

            $this->climate->{$level}()->inline("{$key}: ");

            if (is_array($val)) {
                $this->climate->{$level}("[");
                $this->outputRecursiveContext($level, $val, $indent + 1);
                $this->climate->tab($indent)->{$level}("]");
            } else {
                $this->climate->{$level}((string)$val);
            }
        }
    }
}
