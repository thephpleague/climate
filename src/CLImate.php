<?php

namespace CLImate;

/**
 * @method mixed black(string $str = null)
 * @method mixed red(string $str = null)
 * @method mixed green(string $str = null)
 * @method mixed yellow(string $str = null)
 * @method mixed blue(string $str = null)
 * @method mixed magenta(string $str = null)
 * @method mixed cyan(string $str = null)
 * @method mixed lightGray(string $str = null)
 * @method mixed darkGray(string $str = null)
 * @method mixed lightRed(string $str = null)
 * @method mixed lightGreen(string $str = null)
 * @method mixed lightYellow(string $str = null)
 * @method mixed lightBlue(string $str = null)
 * @method mixed lightMagenta(string $str = null)
 * @method mixed lightCyan(string $str = null)
 * @method mixed white(string $str = null)
 *
 * @method mixed backgroundBlack(string $str = null)
 * @method mixed backgroundRed(string $str = null)
 * @method mixed backgroundGreen(string $str = null)
 * @method mixed backgroundYellow(string $str = null)
 * @method mixed backgroundBlue(string $str = null)
 * @method mixed backgroundMagenta(string $str = null)
 * @method mixed backgroundCyan(string $str = null)
 * @method mixed backgroundLightGray(string $str = null)
 * @method mixed backgroundDarkGray(string $str = null)
 * @method mixed backgroundLightRed(string $str = null)
 * @method mixed backgroundLightGreen(string $str = null)
 * @method mixed backgroundLightYellow(string $str = null)
 * @method mixed backgroundLightBlue(string $str = null)
 * @method mixed backgroundLightMagenta(string $str = null)
 * @method mixed backgroundLightCyan(string $str = null)
 * @method mixed backgroundWhite(string $str = null)
 *
 * @method mixed bold(string $str = null)
 * @method mixed dim(string $str = null)
 * @method mixed underline(string $str = null)
 * @method mixed blink(string $str = null)
 * @method mixed invert(string $str = null)
 * @method mixed hidden(string $str = null)
 *
 * @method mixed info(string $str = null)
 * @method mixed comment(string $str = null)
 * @method mixed whisper(string $str = null)
 * @method mixed shout(string $str = null)
 * @method mixed error(string $str = null)
 *
 * @method mixed table(array $data)
 * @method mixed json(mixed $var)
 * @method mixed br()
 * @method mixed draw(string $art)
 * @method mixed border(string $char = null, integer $length = null)
 * @method mixed dump(mixed $var)
 * @method mixed flank(string $output, string $char = null, integer $length = null)
 * @method mixed progress(integer $total = null)
 *
 * @method \CLImate\CLImate addArt(string $dir)
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
