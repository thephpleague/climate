<?php

namespace CLImate;

/**
 * @method mixed black(string $str (optional))
 * @method mixed red(string $str (optional))
 * @method mixed green(string $str (optional))
 * @method mixed yellow(string $str (optional))
 * @method mixed blue(string $str (optional))
 * @method mixed magenta(string $str (optional))
 * @method mixed cyan(string $str (optional))
 * @method mixed lightGray(string $str (optional))
 * @method mixed darkGray(string $str (optional))
 * @method mixed lightRed(string $str (optional))
 * @method mixed lightGreen(string $str (optional))
 * @method mixed lightYellow(string $str (optional))
 * @method mixed lightBlue(string $str (optional))
 * @method mixed lightMagenta(string $str (optional))
 * @method mixed lightCyan(string $str (optional))
 * @method mixed white(string $str (optional))
 *
 * @method mixed backgroundBlack(string $str (optional))
 * @method mixed backgroundRed(string $str (optional))
 * @method mixed backgroundGreen(string $str (optional))
 * @method mixed backgroundYellow(string $str (optional))
 * @method mixed backgroundBlue(string $str (optional))
 * @method mixed backgroundMagenta(string $str (optional))
 * @method mixed backgroundCyan(string $str (optional))
 * @method mixed backgroundLightGray(string $str (optional))
 * @method mixed backgroundDarkGray(string $str (optional))
 * @method mixed backgroundLightRed(string $str (optional))
 * @method mixed backgroundLightGreen(string $str (optional))
 * @method mixed backgroundLightYellow(string $str (optional))
 * @method mixed backgroundLightBlue(string $str (optional))
 * @method mixed backgroundLightMagenta(string $str (optional))
 * @method mixed backgroundLightCyan(string $str (optional))
 * @method mixed backgroundWhite(string $str (optional))
 *
 * @method mixed bold(string $str (optional))
 * @method mixed dim(string $str (optional))
 * @method mixed underline(string $str (optional))
 * @method mixed blink(string $str (optional))
 * @method mixed invert(string $str (optional))
 * @method mixed hidden(string $str (optional))
 *
 * @method mixed info(string $str (optional))
 * @method mixed comment(string $str (optional))
 * @method mixed whisper(string $str (optional))
 * @method mixed shout(string $str (optional))
 * @method mixed error(string $str (optional))
 *
 * @method mixed table(array $data)
 * @method mixed json(mixed $var)
 * @method mixed br()
 * @method mixed draw(string $art)
 * @method mixed border(string $char (optional), integer $length (optional))
 * @method mixed dump(mixed $var)
 * @method mixed flank(string $output, string $char (optional), integer $length (optional))
 * @method mixed progress(integer $total (optional))
 *
 * @method void addArt(string $dir)
 */

class CLImate
{
    /**
     * An instance of the Style class
     *
     * @var \CLImate\Decorator\Style $style
     */

    public $style;

    /**
     * An instance of the Terminal Object Router class
     *
     * @var \CLImate\TerminalObject\Router $terminal_object
     */

    protected $terminal_object;

    /**
     * An instance of the Settings Manager class
     *
     * @var \CLImate\Settings\Manager $settings
     */

    protected $settings;

    public function __construct()
    {
        $this->style           = new Decorator\Style();
        $this->terminal_object = new TerminalObject\Router();
        $this->settings        = new Settings\Manager();
    }

    /**
	 * Prints the string to the console
	 *
	 * @param string $str
	 */

    public function out($str)
    {
        echo new Output($str, $this->style->parser());

        $this->style->reset();

        return $this;
    }

    /**
     * Check if we have valid output
     *
     * @param  mixed   $output
     * @return boolean
     */

    protected function hasOutput($output)
    {
        if (is_string($output) || is_numeric($output)) {
            if (strlen($output)) {
                return true;
            }

        } elseif (!empty($output)) {
            return true;
        }

        return false;
    }

    /**
     * Search for the method within the string
     * and route it if we find one.
     *
     * @param  string $method
     * @param  string $name
     * @return string The new string without the executed method.
     */

    protected function parseStyleMethod($method, $name)
    {
        // If the name starts with this method string...
        if (substr($name, 0, strlen($method)) == $method) {
            // ...remove the method name from the beginning of the string...
            $name = substr($name, strlen($method));

            // ...and trim off any of those underscores hanging around
            $name = ltrim($name, '_');

            $this->style->set($method);
        }

        return $name;
    }

    /**
     * Search for any style methods within the name and apply them
     *
     * @param  string $name
     * @return string Anything left over after applying styles
     */

    protected function applyStyleMethods($name)
    {
        // Get all of the possible style attributes
        $method_search = array_keys($this->style->all());

        // A flag to see if we are still finding valid methods
        // We need this flag because of terminal objects
        // and failing gracefully when a whack method is passed in
        $found_method = true;

        // While we still have a name left and we keep finding methods,
        // loop through the possibilities
        while (strlen($name) > 0 && $found_method) {
            // We haven't found a method in the current loop yet
            $current_loop_found = false;

            // Loop through the possible methods
            foreach ($method_search as $method) {
                // See if we found a valid method
                $new_name = $this->parseStyleMethod($method, $name);

                // If we haven't found one in the loop yet and the name changed,
                // guess what: we found a valid method
                if (!$current_loop_found && $new_name != $name) {
                    $current_loop_found = true;
                }

                // Set the name to the new name
                $name = $new_name;
            }

            // Set the found method flag just in case we don't have any more valid methods
            $found_method = $current_loop_found;
        }

        return $name;
    }

    /**
     * Magic method for anything called that doesn't exist
     *
     * @param string $requested_method
     * @param array  $arguments
     *
     * List of many of the possible method being called here
     * documented at the top of this class.
     */

    public function __call($requested_method, $arguments)
    {
        // Convert to snake case
        $name   = strtolower(preg_replace('/(.)([A-Z])/', '$1_$2', $requested_method));

        // The first argument is the string|array|object we want to echo out
        $output = reset($arguments);

        $name   = $this->applyStyleMethods($name);

        // If we have fulfilled all of the requested methods and we have output, output it
        if (!strlen($name) && $this->hasOutput($output)) {
            return $this->out($output);
        }

        // If we still have something left, let's see if it's a terminal object
        if (strlen($name)) {
            if ( $this->terminal_object->exists($name)) {
                // Retrieve the parser for the current set of styles
                $parser = $this->style->parser();

                // Reset the styles
                $this->style->reset();

                // Execute the terminal object
                $obj = $this->terminal_object
                            ->settings($this->settings)
                            ->parser($parser)
                            ->execute($name, $arguments);

                // If something was returned, return it
                if ($obj) return $obj;
            } elseif ( $this->settings->exists($name)) {
                $this->settings->add($name, $output);
            } else {
                // If we can't find it at this point, let's fail gracefully
                return $this->out($output);
            }
        }

        return $this;
    }
}
