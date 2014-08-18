<?php

namespace JoeTannenbaum\CLImate;


class CLImate {

    /**
     * An instance of the style class
     *
     * @var JoeTannenbaum\CLImate\Style
     */

    protected $style;

    public function __construct()
    {
        $this->style = new Style();
    }

	/**
	 * Prints the string to the console
	 *
	 * @param string $str
	 * @param string $color
	 */

    public function out( $str )
    {
        echo $this->applyStyle( $str ) . "\n";

        $this->style->reset();
    }

    /**
     * Output a line break to the terminal
     *
     * @return JoeTannenbaum\CLImate\Terminal
     */

    public function br()
    {
        $this->out('');

        return $this;
    }

    /**
     * Output a border
     *
     * @param string $char
     * @param string $color
     * @param integer $length
     */

    public function border( $char = '-', $length = NULL )
    {
        $border = new Border;

        if ( strlen( $char ) )
        {
            $border->char( $char );
        }

        if ( $length )
        {
            $border->length( $length );
        }

        $this->out( $border->result() );
    }

    /**
     * Output a table
     *
     * @param array $data
     */

    public function table( $data )
    {
        $table = new Table( $data, $this->style->tag_search );

        $this->style->persistant();

        foreach ( $table->result() as $row )
        {
            $this->out( $row );
        }

        $this->style->resetPersistant();
    }

    /**
     * JSONify a mixed input to the terminal
     *
     * @param mixed $data
     */

    public function json( $data )
    {
        $json = new JSON( $data );

        $this->out( $json->result() );
    }

    /**
     * Wrap the string in the current style
     *
     * @param string $str
     * @return string
     */

    protected function applyStyle( $str )
    {
        return $this->style->start() . $this->parseTags( $str ) . $this->style->end();
    }

    /**
     * Parse the string for tags and replace them with their codes
     *
     * @param string $str
     * @return string
     */

    protected function parseTags( $str )
    {
        return str_replace( $this->style->tagSearch(), $this->style->tagReplace(), $str );
    }

    /**
     * Based on the $name parameter, checks for combinations of various methods
     * that might exist in either this class or Style
     *
     * @param string $name
     * @param mixed $output
     * @return mixed JoeTannenbaum\CLImate\Terminal
     */

    protected function checkForAdvancedMethods( $name, $output )
    {
        $possible_methods = [
            'background',
            'foreground',
            'format',
            'table',
            'border',
            'json',
        ];

        foreach ( $possible_methods as $method )
        {
            // Method was a postfix (e.g. redTable)
            $postfix = '_' . $method;

            // Method was a prefix (e.g. backgroundRed)
            $prefix  = $method . '_';

            if ( strstr( $name, $postfix ) !== FALSE )
            {
                // Get rid of the method bit
                $style = str_replace( $postfix, '', $name );

                // Get the style based on the method name
                $this->style->foreground( $style );

                $this->$method( $output );

                return $this;
            }
            elseif ( strstr( $name, $prefix ) !== FALSE )
            {
                // Get rid of the method bit
                $style = str_replace( $prefix, '', $name );

                $this->style->$method( $style );

                return $this;
            }
        }
    }

    /**
     * Checks for simple methods that exist in Style,
     * returns TRUE if they exist and are applied
     *
     * @param string $name
     * @return boolean
     */

    protected function checkForSimpleMethods( $name )
    {
        foreach ( [ 'foreground', 'formatting' ] as $method )
        {
            $style_method = 'get' . ucwords( $method );

            $value = $this->style->$style_method( $name );

            if ( $value )
            {
                $this->style->$method( $name );

                return TRUE;
            }
        }

        return FALSE;
    }

    /**
     * Magic method for anything called that doesn't exist
     *
     *
     * @param string $name
     * @param array $arguments
     */

	public function __call( $name, $arguments )
	{
        // Convert to snake case
        $name   = strtolower( preg_replace( '/(.)([A-Z])/', '$1_$2', $name ) );

        // The first argument is the string we want to echo out
        $output = reset( $arguments );

        $found = $this->checkForSimpleMethods( $name );

        if ( $found )
        {
            if ( !$output )
            {
                return $this;
            }
            else
            {
                return $this->out( $output );
            }
        }

        return $this->checkForAdvancedMethods( $name, $output );
    }
}