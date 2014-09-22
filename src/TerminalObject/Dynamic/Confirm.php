<?php

namespace League\CLImate\TerminalObject\Dynamic;

class Confirm extends BaseDynamicTerminalObject
{
    /**
     * If the user chose to confirm
     *
     * @var boolean $confirmed
     */

    protected $confirmed;

    public function __construct($prompt)
    {
        $this->prompt = $prompt;

        $input = new Input($prompt);
        $input->parser($this->parser);
        $input->accept(['y', 'n']);
        $input->strict();
        $this->confirmed = ($input->prompt() == 'y');
    }

    /**
     * Let us know if the user confirmed
     *
     * @return boolean
     */

    public function confirmed()
    {
        return $this->confirmed;
    }
}
