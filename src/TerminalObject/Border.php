<?php

namespace CLImate\TerminalObject;

class Border extends BaseTerminalObject {

	/**
	 * The character to repeat for the border
	 *
	 * @var string $char
	 */

	protected $char = '-';

	/**
	 * The length of the border
	 *
	 * @var integer $length
	 */

	protected $length = 100;

	public function __construct( $char = NULL, $length = NULL )
	{
		if ( $char )
		{
			$this->char( $char );
		}

		if ( $length )
		{
			$this->length( $length );
		}
	}

	/**
	 * Set the character to repeat for the border
	 *
	 * @param string $char
	 * @return CLImate\Border
	 */

	public function char( $char )
	{
		$this->char = $char;

		return $this;
	}

	/**
	 * Set the length of the border
	 *
	 * @param integer $length
	 * @return CLImate\Border
	 */

	public function length( $length )
	{
		$this->length = $length;

		return $this;
	}

	/**
	 * Return the border
	 *
	 * @return string
	 */

	public function result()
	{
        $str = str_repeat( $this->char, $this->length );
        $str = substr( $str, 0, $this->length );

        return $str;
	}
}