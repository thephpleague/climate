<?php

namespace JoeTannenbaum\CLImate\TerminalObject;

class Flank extends BaseTerminalObject {

	/**
	 * The string that will be flanked
	 *
	 * @var string $str
	 */

	protected $str;

	/**
	 * The character(s) to repeat on either side of the string
	 *
	 * @var string $char
	 */

	protected $char = '#';

	/**
	 * How many times the character(s) should be repeated on either side
	 *
	 * @var integer $repeat
	 */

	protected $repeat = 3;

	public function __construct( $str, $char = NULL, $repeat = NULL )
	{
		$this->str = $str;

		if ( $char )
		{
			$this->char( $char );
		}

		if ( $repeat )
		{
			$this->repeat( $repeat );
		}
	}

	/**
	 * Set the character(s) to repeat on either side
	 *
	 * @param string $char
	 * @return JoeTannenbaum\CLImate\TerminalObject\Flank
	 */

	public function char( $char )
	{
		$this->char = $char;

		return $this;
	}

	/**
	 * Set the repeat of the flank character(s)
	 *
	 * @param integer $repeat
	 * @return JoeTannenbaum\CLImate\TerminalObject\Flank
	 */

	public function repeat( $repeat )
	{
		$this->repeat = $repeat;

		return $this;
	}

	/**
	 * Return the flanked string
	 *
	 * @return string
	 */

	public function result()
	{
        $flank = str_repeat( $this->char, $this->repeat );

        return "{$flank} {$this->str} {$flank}";
	}
}