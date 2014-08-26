<?php

namespace JoeTannenbaum\CLImate;


class CLImate {

    /**
     * An instance of the style class
     *
     * @var JoeTannenbaum\CLImate\Style
     */

    public $style;

    public function __construct()
    {
        $this->style = new Style();
    }

	/**
	 * Prints the string to the console
	 *
	 * @param string $str
	 */

    public function out( $str )
    {
        echo $this->applyStyle( $str ) . "\n";

        $this->style->reset();

        return $this;
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
     * Get the full path for a terminal object class
     *
     * @param string $name
     * @return string
     */

    protected function getFullTerminalObjectClass( $name )
    {
        return 'JoeTannenbaum\\CLImate\\TerminalObject\\' . ucwords( $name );
    }

    /**
     * Get the full path for a dynamic terminal object class
     *
     * @param string $name
     * @return string
     */

    protected function getFullDynamicTerminalObjectClass( $name )
    {
        return 'JoeTannenbaum\\CLImate\\TerminalObject\\Dynamic\\' . ucwords( $name );
    }

    /**
     * Execute a terminal object using given arguments
     *
     * @param string $name
     * @param mixed $arguments
     */

    protected function executeTerminalObject( $name, $arguments )
    {
        $reflect = new \ReflectionClass( $this->getFullTerminalObjectClass( $name ) );
        $obj     = $reflect->newInstanceArgs( $arguments );

        $results = $obj->result();

        if ( !is_array( $results ) )
        {
            $results = [ $results ];
        }

        $this->style->persistent();

        foreach ( $results as $result )
        {
            $this->out( $result );
        }

        $this->style->resetPersistent();
    }

    /**
     * Execute a dynamic terminal object using given arguments
     *
     * @param string $name
     * @param mixed $arguments
     */

    protected function executeDynamicTerminalObject( $name, $arguments )
    {
        $reflect = new \ReflectionClass( $this->getFullDynamicTerminalObjectClass( $name ) );
        $obj     = $reflect->newInstanceArgs( $arguments );

        $obj->cli( $this );

        return $obj;
    }

    /**
     * Route a method to its appropriate class and execute it
     *
     * @param string $method
     * @return boolean
     */

    protected function routeMethod( $method )
    {
        // Manual check, if it starts with the background string, it's a background method
        if ( substr( $method, 0, strlen('background_' ) ) == 'background_' )
        {
            $this->style->background( str_replace( 'background_', '', $method ) );

            return TRUE;
        }
        else if ( $this->style->getForeground( $method ) )
        {
            $this->style->foreground( $method );

            return TRUE;
        }
        else if ( $this->style->getFormatting( $method ) )
        {
            $this->style->formatting( $method );

            return TRUE;
        }

        return FALSE;
    }

    /**
     * Check if we have valid output
     *
     * @param mixed $output
     * @return boolean
     */

    protected function hasOutput( $output )
    {
        if ( is_string( $output ) || is_numeric( $output ) )
        {
            if ( strlen( $output ) )
            {
                return TRUE;
            }

        } else if ( !empty( $output ) )
        {
            return TRUE;
        }

        return FALSE;
    }

    /**
     * Search for the method within the string
     * and route it if we find one
     *
     * @param string $method
     * @param string $name
     * @return string
     */

    protected function searchForMethod( $method, $name )
    {
        // If the name starts with this method string...
        if ( substr( $name, 0, strlen( $method ) ) == $method )
        {
            // ...remove the method name from the beginning of the string...
            $name = substr( $name, strlen( $method ) );

            // ...and trim off any of those underscores hanging around
            $name = ltrim( $name, '_' );

            $this->routeMethod( $method );
        }

        return $name;
    }

    /**
     * Magic method for anything called that doesn't exist
     *
     * Looking for methods such as:
     *
     * - red
     * - redTable
     * - backgroundRed
     * - backgroundRedTable
     * - blink
     * - blinkTable
     *
     * @param string $name
     * @param array $arguments
     */

	public function __call( $requested_method, $arguments )
	{
        // Convert to snake case
        $name   = strtolower( preg_replace( '/(.)([A-Z])/', '$1_$2', $requested_method ) );

        // The first argument is the string|array|object we want to echo out
        $output = reset( $arguments );

        // Get all of the possible style attributes
        $method_search = array_keys( $this->style->getMergedAttributes() );

        // A flag to see if we are still finding valid methods
        // We need this flag because of terminal objects
        // and failing gracefully when a whack method is passed in
        $found_method = TRUE;

        // While we still have a name left and we keep finding methods,
        // loop through the possibilities
        while ( strlen( $name ) > 0 && $found_method )
        {
            // We haven't found a method in the current loop yet
            $current_loop_found = FALSE;

            // Loop through the possible methods
            foreach ( $method_search as $method )
            {
                // See if we found a valid method
                $new_name = $this->searchForMethod( $method, $name );

                // If we haven't found one in the loop yet and the name changed,
                // guess what: we found a valid method
                if ( !$current_loop_found && $new_name != $name )
                {
                    $current_loop_found = TRUE;
                }

                // Reset name to the new name
                $name = $new_name;
            }

            // Set the found method flag just in case we don't have any more valid methods
            $found_method = $current_loop_found;
        }

        // If we have fulfilled all of the requested methods and we have output, output it
        if ( !strlen( $name ) && $this->hasOutput( $output ) )
        {
            return $this->out( $output );
        }

        // If we still have something left, let's see if it's a terminal object
        if ( strlen( $name ) )
        {
            // If it is, let's execute it
            if ( class_exists( $this->getFullTerminalObjectClass( $name ) ) )
            {
                $this->executeTerminalObject( $name, $arguments );
            }
            else if ( class_exists( $this->getFullDynamicTerminalObjectClass( $name ) ) )
            {
                return $this->executeDynamicTerminalObject( $name, $arguments );
            }
            else
            {
                // If we can't find it at this point, let's fail gracefully
                return $this->out( $output );
            }
        }

        return $this;
    }
}
