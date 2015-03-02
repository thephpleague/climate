<?php

namespace League\CLImate;

use Psr\Log\AbstractLogger;

/**
 * A PSR-3 compatiable logger that uses CLImate for output.
 */
class Logger extends AbstractLogger
{
    /**
     * @var CLImate $climate The underlying climate instance we are using for output.
     */
    protected $climate;

    /**
     * Create a new Logger instance.
     *
     * @param CLImate $climate An existing CLImate instance to use for output
     */
    public function __construct(CLImate $climate = null)
    {
        if ($climate === null) {
            $climate = new CLImate;
        }
        $this->climate = $climate;

        # Define some default styles to use for the
        $commands = [
            "emergency" =>  ["white", "bold", "background_red"],
            "alert"     =>  ["white", "background_yellow"],
            "critical"  =>  ["red", "bold"],
            "error"     =>  ["red"],
            "warning"   =>  "yellow",
            "notice"    =>  "light_cyan",
            "info"      =>  "green",
            "debug"     =>  "dark_gray",
        ];

        # If any of the required styles are not defined then define them now
        foreach ($commands as $command => $style) {
            if (!$this->climate->style->get($command)) {
                $this->climate->style->addCommand($command, $style);
            }
        }
    }

    /**
     * Log messages to a CLImate instance.
     *
     * @param mixed          $level    The level of the log message
     * @param string|object  $message  If an object is passed it must implement __toString()
     * @param array          $context  Placeholders to be substituted in the message
     *
     * @return static
     */
    public function log($level, $message, array $context = [])
    {
        # Handle objects implementing __toString
        $message = (string) $message;

        # Handle any placeholders in the $context array
        foreach ($context as $key => $val) {
            $placeholder = "{" . $key . "}";

            # If this context key is used as a placeholder, then replace it, and remove it from the $context array
            if (strpos($message, $placeholder) !== false) {
                $val = (string) $val;
                $message = str_replace($placeholder, $val, $message);
                unset($context[$key]);
            }
        }

        # Send the message to the climate instance
        $this->climate->{$level}($message);

        # Append any context information not used as placeholders
        $this->outputRecursiveContext($level, $context, 1);

        return $this;
    }

    /**
     * Handle recursive arrays in the logging context.
     *
     * @param mixed  $level    The level of the log message
     * @param array  $context  The array of context to output
     * @param int    $indent   The current level of indentation to be used
     *
     * @return vvoid
     */
    protected function outputRecursiveContext($level, array $context, $indent)
    {
        foreach ($context as $key => $val) {
            $this->climate->tab($indent);

            $this->climate->{$level}()->inline("{$key}: ");

            if (is_array($val)) {
                $this->climate->{$level}("[");
                $this->outputRecursiveContext($level, $val, $indent + 1);
                $this->climate->tab($indent)->{$level}("]");
            } else {
                $this->climate->{$level}((string) $val);
            }
        }
    }
}
