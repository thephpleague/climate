<?php

namespace League\CLImate\TerminalObject\Dynamic;

use League\CLImate\Util\Reader\ReaderInterface;
use League\CLImate\Util\Reader\Stdin;

class Input extends InputAbstract
{
    /**
     * An array of acceptable responses
     *
     * @var array|object $acceptable
     */
    protected $acceptable;

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

    /**
     * A default answer in the case of no user response,
     * prevents re-prompting
     *
     * @var string
     */
    protected $default = '';

    /**
     * Whether or not we should print out the user's response as they type it
     *
     * @var bool
     */
    protected $hide_response = false;

    public function __construct($prompt, ReaderInterface $reader = null)
    {
        $this->prompt = $prompt;
        $this->reader = $reader ?: new Stdin();
    }

    /**
     * Do it! Prompt the user for information!
     *
     * @return string
     */
    public function prompt()
    {
        $prompt_str = $this->parser->apply($this->promptFormatted());

        if ($this->hide_response) {
            return $this->util->system->hiddenResponsePrompt($prompt_str);
        }

        $this->output->sameLine()->write($prompt_str);

        $response = $this->valueOrDefault($this->reader->line());

        if ($this->isValidResponse($response)) {
            return $response;
        }

        return $this->prompt();
    }

    /**
     * Define the acceptable responses and whether or not to
     * display them to the user
     *
     * @param  array|object $acceptable
     * @param  boolean $show
     *
     * @return \League\CLImate\TerminalObject\Dynamic\Input
     */
    public function accept($acceptable, $show = false)
    {
        $this->acceptable      = $acceptable;
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
     * Set a default response
     *
     * @param string $default
     *
     * @return \League\CLImate\TerminalObject\Dynamic\Input
     */
    public function defaultTo($default)
    {
        $this->default = $default;

        return $this;
    }

    /**
     * Hide the user's response
     *
     * @throws \Exception if it does not have access to bash
     */
    public function hideResponse()
    {
        if (!$this->util->system->canAccessBash()) {
            throw new \Exception('Cannot access bash, unable to hide response.');
        }

        $this->hide_response = true;
    }

    /**
     * If no response was given and there is a default, return it,
     * otherwise return response
     *
     * @param string $response
     *
     * @return string
     */
    protected function valueOrDefault($response)
    {
        if (strlen($response) == 0 && strlen($this->default)) {
            return $this->default;
        }

        return $response;
    }

    /**
     * Format the acceptable responses as options
     *
     * @return string
     */
    protected function acceptableFormatted()
    {
        if (!is_array($this->acceptable)) {
            return '';
        }

        $this->acceptable = array_map([$this, 'acceptableItemFormatted'], $this->acceptable);

        return '[' . implode('/', $this->acceptable) . ']';
    }

    /**
     * Format the acceptable item depending on whether it is the default or not
     *
     * @param string $item
     *
     * @return string
     */
    protected function acceptableItemFormatted($item)
    {
        if ($item == $this->default) {
            return '<bold>' . $item . '</bold>';
        }

        return $item;
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
     * @return array
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
     * Determine whether or not the acceptable property is of type closure
     *
     * @return boolean
     */
    protected function acceptableIsClosure()
    {
        return (is_object($this->acceptable) && $this->acceptable instanceof \Closure);
    }

    /**
     * Determine if the user's response is in the acceptable responses array
     *
     * @param string $response
     *
     * @return boolean $response
     */
    protected function isAcceptableResponse($response)
    {
        if ($this->strict) {
            return in_array($response, $this->acceptable);
        }

        $acceptable = $this->levelPlayingField($this->acceptable);
        $response   = $this->levelPlayingField($response);

        return in_array($response, $acceptable);
    }

    /**
     * Determine if the user's response is valid based on the current settings
     *
     * @param string $response
     *
     * @return boolean $response
     */
    protected function isValidResponse($response)
    {
        if (empty($this->acceptable)) {
            return true;
        }

        if ($this->acceptableIsClosure()) {
            return call_user_func($this->acceptable, $response);
        }

        return $this->isAcceptableResponse($response);
    }
}
