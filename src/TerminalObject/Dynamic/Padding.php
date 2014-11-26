<?php

namespace League\CLImate\TerminalObject\Dynamic;

class Padding extends BaseDynamicTerminalObject
{
    /**
     * The length that lines should be padded too
     *
     * @var integer $length
     */

    protected $length = 0;

    /**
     * The character(s) that should be used to pad
     *
     * @var string $chars
     */

    protected $chars = ".";

    /**
     * If the output should add a new line at the end or not
     *
     * @var boolean $inline
     */

    protected $inline = false;


    /**
     * If they pass in a padding character, set the chars
     *
     * @param string $chars
     */

    public function __construct($length = null, $chars = null)
    {
        if ($length) {
            $this->length($length);
        }
        if (is_string($chars)) {
            $this->padWith($chars);
        }
    }

    /**
     * Set the character(s) that should be used to pad
     *
     * @param string $chars
     *
     * @return Padding
     */

    public function padWith($chars)
    {
        $this->chars = $chars;

        return $this;
    }

    /**
     * Set the length of the line that should be generated
     *
     * @param integer $length
     *
     * @return Padding
     */

    public function length($length)
    {
        $this->length = $length;

        return $this;
    }

    /**
     * Get the length of the line based on the width of the terminal window
     *
     * @return integer
     */

    protected function getLength()
    {
        if (!$this->length) {
            $this->length = $this->util->dimensions->width();
        }

        return $this->length;
    }

    /**
     * Output the content and pad to the previously defined length, without a newline
     *
     * @param string $content
     *
     * @return Padding
     */

    public function inline($content)
    {
        $this->inline = true;
        $this->pad($content);
        $this->inline = false;

        return $this;
    }

    /**
     * Output the content and pad to the previously defined length
     *
     * @param string $content
     *
     * @return Padding
     */

    public function pad($content)
    {
        $length = $this->getLength();
        $max = $this->util->dimensions->width();

        if (strlen($content) > $max) {
            $lines = str_split($content, $max);
            $content = array_pop($lines);
            foreach ($lines as $line) {
                $this->output->write($line);
            }
        }

        if (strlen($content) < $length && strlen($this->chars) > 0) {
            $padding = str_repeat($this->chars, ceil($length / strlen($this->chars)));
            $content .= substr($padding, strlen($content));
        }

        $this->out($content);

        return $this;
    }


    /**
     * Output the content
     *
     * @param string $content
     *
     * @return Padding
     */
    public function out($content)
    {
        if ($this->inline) {
            $this->output->sameLine();
        }
        $this->output->write($content);

        return $this;
    }
}
