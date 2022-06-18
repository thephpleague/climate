<?php

namespace League\CLImate;

use League\CLImate\Argument\Manager as ArgumentManager;
use League\CLImate\Decorator\Style;
use League\CLImate\Settings\Manager as SettingsManager;
use League\CLImate\TerminalObject\Dynamic\Spinner;
use League\CLImate\TerminalObject\Router\Router;
use League\CLImate\Util\Helper;
use League\CLImate\Util\Output;
use League\CLImate\Util\UtilFactory;

/**
 * @method CLImate black(string $str = null)
 * @method CLImate red(string $str = null)
 * @method CLImate green(string $str = null)
 * @method CLImate yellow(string $str = null)
 * @method CLImate blue(string $str = null)
 * @method CLImate magenta(string $str = null)
 * @method CLImate cyan(string $str = null)
 * @method CLImate lightGray(string $str = null)
 * @method CLImate darkGray(string $str = null)
 * @method CLImate lightRed(string $str = null)
 * @method CLImate lightGreen(string $str = null)
 * @method CLImate lightYellow(string $str = null)
 * @method CLImate lightBlue(string $str = null)
 * @method CLImate lightMagenta(string $str = null)
 * @method CLImate lightCyan(string $str = null)
 * @method CLImate white(string $str = null)
 *
 * @method CLImate backgroundBlack(string $str = null)
 * @method CLImate backgroundRed(string $str = null)
 * @method CLImate backgroundGreen(string $str = null)
 * @method CLImate backgroundYellow(string $str = null)
 * @method CLImate backgroundBlue(string $str = null)
 * @method CLImate backgroundMagenta(string $str = null)
 * @method CLImate backgroundCyan(string $str = null)
 * @method CLImate backgroundLightGray(string $str = null)
 * @method CLImate backgroundDarkGray(string $str = null)
 * @method CLImate backgroundLightRed(string $str = null)
 * @method CLImate backgroundLightGreen(string $str = null)
 * @method CLImate backgroundLightYellow(string $str = null)
 * @method CLImate backgroundLightBlue(string $str = null)
 * @method CLImate backgroundLightMagenta(string $str = null)
 * @method CLImate backgroundLightCyan(string $str = null)
 * @method CLImate backgroundWhite(string $str = null)
 *
 * @method CLImate bold(string $str = null)
 * @method CLImate dim(string $str = null)
 * @method CLImate underline(string $str = null)
 * @method CLImate blink(string $str = null)
 * @method CLImate invert(string $str = null)
 * @method CLImate hidden(string $str = null)
 *
 * @method CLImate info(string $str = null)
 * @method CLImate comment(string $str = null)
 * @method CLImate whisper(string $str = null)
 * @method CLImate shout(string $str = null)
 * @method CLImate error(string $str = null)
 *
 * @method mixed out(string $str)
 * @method mixed inline(string $str)
 * @method mixed table(array $data)
 * @method mixed json(mixed $var)
 * @method mixed br($count = 1)
 * @method mixed tab($count = 1)
 * @method mixed draw(string $art)
 * @method mixed border(string $char = null, integer $length = null)
 * @method mixed dump(mixed $var)
 * @method mixed flank(string $output, string $char = null, integer $length = null)
 * @method mixed progress(integer $total = null)
 * @method Spinner spinner(string $label = null, string ...$characters = null)
 * @method mixed padding(integer $length = 0, string $char = '.')
 * @method mixed input(string $prompt, Util\Reader\ReaderInterface $reader = null)
 * @method mixed confirm(string $prompt, Util\Reader\ReaderInterface $reader = null)
 * @method mixed password(string $prompt, Util\Reader\ReaderInterface $reader = null)
 * @method mixed checkboxes(string $prompt, array $options, Util\Reader\ReaderInterface $reader = null)
 * @method mixed radio(string $prompt, array $options, Util\Reader\ReaderInterface $reader = null)
 * @method mixed animation(string $art, TerminalObject\Helper\Sleeper $sleeper = null)
 * @method mixed columns(array $data, $column_count = null)
 * @method mixed clear()
 * @method CLImate clearLine()
 *
 * @method CLImate addArt(string $dir)
 */
class CLImate
{
    /**
     * An instance of the Style class
     *
     * @var \League\CLImate\Decorator\Style $style
     */
    public $style;

    /**
     * An instance of the Terminal Object Router class
     *
     * @var \League\CLImate\TerminalObject\Router\Router $router
     */
    protected $router;

    /**
     * An instance of the Settings Manager class
     *
     * @var \League\CLImate\Settings\Manager $settings
     */
    protected $settings;

    /**
     * An instance of the Argument Manager class
     *
     * @var \League\CLImate\Argument\Manager $arguments
     */
    public $arguments;

    /**
     * An instance of the Output class
     *
     * @var \League\CLImate\Util\Output $output
     */
    public $output;

    /**
     * An instance of the Util Factory
     *
     * @var \League\CLImate\Util\UtilFactory $util
     */
    protected $util;

    public function __construct()
    {
        $this->setStyle(new Style());
        $this->setRouter(new Router());
        $this->setSettingsManager(new SettingsManager());
        $this->setOutput(new Output());
        $this->setUtil(new UtilFactory());
        $this->setArgumentManager(new ArgumentManager());
    }

    /**
     * Set the style property
     *
     * @param \League\CLImate\Decorator\Style $style
     */
    public function setStyle(Style $style)
    {
        $this->style = $style;
    }

    /**
     * Set the router property
     *
     * @param \League\CLImate\TerminalObject\Router\Router $router
     */
    public function setRouter(Router $router)
    {
        $this->router = $router;
    }

    /**
     * Set the settings property
     *
     * @param \League\CLImate\Settings\Manager $manager
     */
    public function setSettingsManager(SettingsManager $manager)
    {
        $this->settings = $manager;
    }

    /**
     * Set the arguments property
     *
     * @param \League\CLImate\Argument\Manager $manager
     */
    public function setArgumentManager(ArgumentManager $manager)
    {
        $this->arguments = $manager;
    }

    /**
     * Set the output property
     *
     * @param \League\CLImate\Util\Output $output
     */
    public function setOutput(Output $output)
    {
        $this->output = $output;
    }

    /**
     * Set the util property
     *
     * @param \League\CLImate\Util\UtilFactory $util
     */
    public function setUtil(UtilFactory $util)
    {
        $this->util = $util;
    }

    /**
     * Extend CLImate with custom methods
     *
     * @param string|object|array $class
     * @param string $key Optional custom key instead of class name
     *
     * @return \League\CLImate\CLImate
     */
    public function extend($class, $key = null)
    {
        $this->router->addExtension($key, $class);

        return $this;
    }

    /**
     * Force ansi support on
     *
     * @return \League\CLImate\CLImate
     */
    public function forceAnsiOn()
    {
        $this->util->system->forceAnsi();

        return $this;
    }

    /**
     * Force ansi support off
     *
     * @return \League\CLImate\CLImate
     */
    public function forceAnsiOff()
    {
        $this->util->system->forceAnsi(false);

        return $this;
    }

    /**
     * Write line to writer once
     *
     * @param string|array $writer
     *
     * @return \League\CLImate\CLImate
     */
    public function to($writer)
    {
        $this->output->once($writer);

        return $this;
    }

    /**
     * Output the program's usage statement
     *
     * @param array $argv
     * @return void
     */
    public function usage(array $argv = null)
    {
        $this->arguments->usage($this, $argv);
    }

    /**
     * Set the program's description
     *
     * @param string $description
     *
     * @return \League\CLImate\CLImate
     */
    public function description($description)
    {
        $this->arguments->description($description);

        return $this;
    }

    /**
     * Check if we have valid output
     *
     * @param  mixed   $output
     *
     * @return boolean
     */
    protected function hasOutput($output)
    {
        if (!empty($output)) {
            return true;
        }

        // Check for type first to avoid errors with objects/arrays/etc
        return ((is_string($output) || is_numeric($output)) && strlen($output) > 0);
    }

    /**
     * Search for the method within the string
     * and route it if we find one.
     *
     * @param  string $method
     * @param  string $name
     *
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
     * @param  array $method_search
     *
     * @return string Anything left over after applying styles
     */
    protected function applyStyleMethods($name, $method_search = null)
    {
        // Get all of the possible style attributes
        $method_search = $method_search ?: array_keys($this->style->all());

        $new_name = $this->searchForStyleMethods($name, $method_search);

        // While we still have a name left and we keep finding methods,
        // loop through the possibilities
        if (strlen($new_name) > 0 && $new_name != $name) {
            return $this->applyStyleMethods($new_name, $method_search);
        }

        return $new_name;
    }

    /**
     * Search for style methods in the current name
     *
     * @param string $name
     * @param array $search
     * @return string
     */
    protected function searchForStyleMethods($name, $search)
    {
        // Loop through the possible methods
        foreach ($search as $method) {
            // See if we found a valid method
            $name = $this->parseStyleMethod($method, $name);
        }

        return $name;
    }

    /**
     * Build up the terminal object and return it
     *
     * @param string $name
     * @param array $arguments
     *
     * @return object|null
     */
    protected function buildTerminalObject($name, $arguments)
    {
        // Retrieve the parser for the current set of styles
        $parser = $this->style->parser($this->util->system);

        // Reset the styles
        $this->style->reset();

        // Execute the terminal object
        $this->router->settings($this->settings);
        $this->router->parser($parser);
        $this->router->output($this->output);
        $this->router->util($this->util);

        return $this->router->execute($name, $arguments);
    }

    /**
     * Route anything leftover after styles were applied
     *
     * @param string $name
     * @param array $arguments
     *
     * @return object|null
     */
    protected function routeRemainingMethod($name, array $arguments)
    {
        // If we still have something left, let's figure out what it is
        if ($this->router->exists($name)) {
            $obj = $this->buildTerminalObject($name, $arguments);

            // If something was returned, return it
            if (is_object($obj)) {
                return $obj;
            }
        } elseif ($this->settings->exists($name)) {
            $this->settings->add($name, reset($arguments));
        // Handle passthroughs to the arguments manager.
        } else {
            // If we can't find it at this point, let's fail gracefully
            $this->out(reset($arguments));
        }
    }

    /**
     * Magic method for anything called that doesn't exist
     *
     * @param string $requested_method
     * @param array  $arguments
     *
     * @return \League\CLImate\CLImate|\League\CLImate\TerminalObject\Dynamic\DynamicTerminalObject
     *
     * List of many of the possible method being called here
     * documented at the top of this class.
     */
    public function __call($requested_method, $arguments)
    {
        // Apply any style methods that we can find first
        $name = $this->applyStyleMethods(Helper::snakeCase($requested_method));

        // The first argument is the string|array|object we want to echo out
        $output = reset($arguments);

        if (strlen($name)) {
            // If we have something left, let's try and route it to the appropriate place
            if ($result = $this->routeRemainingMethod($name, $arguments)) {
                return $result;
            }
        } elseif ($this->hasOutput($output)) {
            // If we have fulfilled all of the requested methods and we have output, output it
            $this->out($output);
        }

        return $this;
    }
}
