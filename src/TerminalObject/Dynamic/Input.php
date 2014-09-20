<?php

namespace League\CLImate\TerminalObject\Dynamic;

use League\CLImate\Util\Reader;

class Input extends BaseDynamicTerminalObject
{
    /**
     * The prompt text
     *
     * @var string $prompt
     */

    protected $prompt;

    /**
     * An array of acceptable responses
     *
     * @var array $acceptable
     */

    protected $acceptable = [];

    /**
     * Whether we should be strict about the response given
     *
     * @var boolean $strict
     */

    protected $strict = false;

    /**
     * Whether we should display the acceptable responses to the user
     *
     * @var boolean $show_acceptable
     */

    protected $show_acceptable = false;

    public function __construct($prompt, $reader = null)
    {
        $this->prompt = $prompt;
        $this->reader = $reader ?: new Reader();
    }

    /**
     * Do it! Prompt the user for information!
     *
     * @return string
     */

    public function prompt()
    {
        echo $this->promptFormatted();

        $response = $this->reader->line();

        if ($this->isValidResponse($response)) {
            return $response;
        }

        return $this->prompt();
    }

    /**
     * Define the acceptable responses and whether or not to
     * display them to the user
     *
     * @param  array $acceptable
     * @param  boolean $show
     *
     * @return \League\CLImate\TerminalObject\Dynamic\Input
     */

    public function accept($acceptable, $show = false)
    {
        $this->acceptable = (array) $acceptable;
        $this->show_acceptable = $show;

        return $this;
    }

    /**
     * Define whether we should be strict about exact responses
     *
     * @return \League\CLImate\TerminalObject\Dynamic\Input
     */

    public function strict()
    {
        $this->strict = true;

        return $this;
    }

    /**
     * Format the acceptable responses as options
     *
     * @return string
     */

    protected function acceptableFormatted()
    {
        return '[' . implode('/', $this->acceptable) . ']';
    }

    /**
     * Format the prompt incorporating spacing and any acceptable options
     *
     * @return string
     */

    protected function promptFormatted()
    {
        $prompt = $this->prompt . ' ';

        if ($this->show_acceptable) {
            $prompt .= $this->acceptableFormatted() . ' ';
        }

        return $prompt;
    }

    /**
     * Apply some string manipulation functions for normalization
     *
     * @param string|array $var
     */

    protected function levelPlayingField($var)
    {
        $levelers = ['trim', 'strtolower'];

        foreach ($levelers as $leveler) {
            if (is_array($var)) {
                $var = array_map($leveler, $var);
            } else {
                $var = $leveler($var);
            }
        }

        return $var;
    }

    /**
     * Determine if the user's response is valid
     * according to the acceptable responses array
     *
     * @param boolean $response
     */

    protected function isValidResponse($response)
    {
        if (empty($this->acceptable)) return true;

        if (!$this->strict) {
            $this->acceptable = $this->levelPlayingField($this->acceptable);
            $response         = $this->levelPlayingField($response);
        }

        return in_array($response, $this->acceptable);
    }
}
