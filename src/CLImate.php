<?php

namespace CLImate;

/**
 * @method mixed black()
 * @method mixed red()
 * @method mixed green()
 * @method mixed yellow()
 * @method mixed blue()
 * @method mixed magenta()
 * @method mixed cyan()
 * @method mixed lightGray()
 * @method mixed darkGray()
 * @method mixed lightRed()
 * @method mixed lightGreen()
 * @method mixed lightYellow()
 * @method mixed lightBlue()
 * @method mixed lightMagenta()
 * @method mixed lightCyan()
 * @method mixed white()
 *
 * @method mixed backgroundBlack()
 * @method mixed backgroundRed()
 * @method mixed backgroundGreen()
 * @method mixed backgroundYellow()
 * @method mixed backgroundBlue()
 * @method mixed backgroundMagenta()
 * @method mixed backgroundCyan()
 * @method mixed backgroundLightGray()
 * @method mixed backgroundDarkGray()
 * @method mixed backgroundLightRed()
 * @method mixed backgroundLightGreen()
 * @method mixed backgroundLightYellow()
 * @method mixed backgroundLightBlue()
 * @method mixed backgroundLightMagenta()
 * @method mixed backgroundLightCyan()
 * @method mixed backgroundWhite()
 *
 * @method mixed bold()
 * @method mixed dim()
 * @method mixed underline()
 * @method mixed blink()
 * @method mixed invert()
 * @method mixed hidden()
 *
 * @method mixed table( array $data )
 * @method mixed json( mixed $var )
 * @method mixed br()
 * @method mixed draw( string $art )
 * @method mixed border( string $char, integer $length )
 * @method mixed dump( mixed $var )
 * @method mixed flank( string $output )
 */

class CLImate {

    /**
     * An instance of the style class
     *
     * @var CLImate\Style $style
     */

    public $style;

    /**
     * A collection of CLImate\TerminalObject\Settings objects
     *
     * @var array $setting
     */

    protected $settings = [];

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
        return '\\CLImate\\TerminalObject\\' . ucwords( $name );
    }

    /**
     * Get the full path for a dynamic terminal object class
     *
     * @param string $name
     * @return string
     */

    protected function getFullDynamicTerminalObjectClass( $name )
    {
        return '\\CLImate\\TerminalObject\\Dynamic\\' . ucwords( $name );
    }

    /**
     * Get the short name for the requested settings class
     *
     * @param string $name
     * @return string
     */

    protected function getSettingsClass( $name )
    {
        return ucwords( str_replace( 'add_', '', $name ) );
    }

    /**
     * Get the full path for a settings class
     *
     * @param string $name
     * @return string
     */

    protected function getFullSettingsClass( $name )
    {
        $name = $this->getSettingsClass( $name );

        return '\\CLImate\\TerminalObject\\Settings\\' . $name;
    }

    /**
     * Add the Settings object into the array
     *
     * @param string $name
     * @param array $arguments
     */

    protected function addSetting( $name, $arguments )
    {
        $name = $this->getSettingsClass( $name );

        if ( !array_key_exists( $name, $this->settings ) )
        {
            $settings_class = $this->getFullSettingsClass( $name );
            $this->settings[ $name ] = new $settings_class;
        }

        $this->settings[ $name ]->add( reset( $arguments ) );
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

        // If the object needs any settings, import them
        foreach ( $obj->settings() as $setting )
        {
            if ( array_key_exists( $setting, $this->settings ) )
            {
                $obj->importSetting( $this->settings[ $setting ] );
            }
        }

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
     * @param string $name
     * @param array $arguments
     *
     * List of many of the possible method being called here
     * documented at the top of this class.
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
            else if ( class_exists( $this->getFullSettingsClass( $name ) ) )
            {
                $this->addSetting( $name, $arguments );
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
