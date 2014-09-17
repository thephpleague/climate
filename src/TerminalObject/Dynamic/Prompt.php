<?php

namespace League\CLImate\TerminalObject\Dynamic;

class Prompt extends BaseDynamicTerminalObject
{
    protected $question;

    protected $acceptable = [];

    protected $strict = false;

    public function __construct($question, $acceptable = [], $strict = false)
    {
        $this->question   = $question;
        $this->acceptable = $acceptable;
        $this->strict     = $strict;

        if (!$this->strict) {
            $this->acceptable = $this->levelField($this->acceptable);
        }
    }

    public function ask()
    {
        $response = readline($this->question . ' ');

        if ($this->isValidResponse($response)) {
            return $response;
        }

        return $this->ask();
    }

    protected function levelField($var)
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

    protected function isValidResponse($response)
    {
        if (empty($this->acceptable)) return true;

        if (!$this->strict) {
            $response = $this->levelField($response);
        }

        return in_array($response, $this->acceptable);
    }
}
