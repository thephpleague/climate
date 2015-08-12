<?php

namespace League\CLImate\TerminalObject\Router;

use League\CLImate\Decorator\Parser\ParserImporter;
use League\CLImate\Settings\Manager;
use League\CLImate\Settings\SettingsImporter;
use League\CLImate\Util\Helper;
use League\CLImate\Util\OutputImporter;
use League\CLImate\Util\UtilImporter;

class Router
{
    use ParserImporter, SettingsImporter, OutputImporter, UtilImporter;

    /**
     * An instance of the Settings Manager class
     *
     * @var \League\CLImate\Settings\Manager $settings;
     */
    protected $settings;

    /**
     * An instance of the Dynamic Router class
     *
     * @var \League\CLImate\TerminalObject\Router\DynamicRouter $dynamic;
     */
    protected $dynamic;

    /**
     * An instance of the Basic Router class
     *
     * @var \League\CLImate\TerminalObject\Router\BasicRouter $basic;
     */
    protected $basic;

    /**
     * @var string $basic_interface
     */
    protected $basic_interface = 'League\CLImate\TerminalObject\Basic\BasicTerminalObjectInterface';

    /**
     * @var string $dynamic_interface
     */
    protected $dynamic_interface = 'League\CLImate\TerminalObject\Dynamic\DynamicTerminalObjectInterface';

    public function __construct(DynamicRouter $dynamic = null, BasicRouter $basic = null)
    {
        $this->dynamic = $dynamic ?: new DynamicRouter();
        $this->basic   = $basic ?: new BasicRouter();
    }

    /**
     * Register a custom class with the router
     *
     * @param string $key
     * @param string $class
     */
    public function addExtension($key, $class)
    {
        $key = $this->getExtensionKey($key, $class);

        $this->validateExtension($class);

        if (is_a($class, $this->basic_interface, is_string($class))) {
            return $this->basic->addExtension($key, $class);
        }

        return $this->dynamic->addExtension($key, $class);
    }

    /**
     * Check if the name matches an existing terminal object
     *
     * @param string $name
     *
     * @return boolean
     */
    public function exists($name)
    {
        return ($this->basic->exists($name) || $this->dynamic->exists($name));
    }

    /**
     * Execute a terminal object using given arguments
     *
     * @param string $name
     * @param mixed  $arguments
     *
     * @return null|\League\CLImate\TerminalObject\Basic\BasicTerminalObjectInterface
     */
    public function execute($name, $arguments)
    {
        $router = $this->getRouter($name);

        $router->output($this->output);

        $obj = $this->getObject($router, $name, $arguments);

        $obj->parser($this->parser);
        $obj->util($this->util);

        // If the object needs any settings, import them
        foreach ($obj->settings() as $obj_setting) {
            $setting = $this->settings->get($obj_setting);

            if ($setting) {
                $obj->importSetting($setting);
            }
        }

        return $router->execute($obj);
    }

    /**
     * Determine the extension key based on the class
     *
     * @param string|null $key
     * @param string|object $class
     *
     * @return string
     */
    protected function getExtensionKey($key, $class)
    {
        if ($key === null || !is_string($key)) {
            $class_path = (is_string($class)) ? $class : get_class($class);

            $key = explode('\\', $class_path);
            $key = end($key);
        }

        return Helper::snakeCase($key);
    }

    /**
     * Ensure that the extension is valid
     *
     * @param string|object $class
     */
    protected function validateExtension($class)
    {
        $this->validateClassExists($class);
        $this->validateClassImplementation($class);
    }

    /**
     * @param string|object $class
     *
     * @throws \Exception if extension class does not exist
     */
    protected function validateClassExists($class)
    {
        if (is_string($class) && !class_exists($class)) {
            throw new \Exception('Class does not exist: ' . $class);
        }
    }

    /**
     * @param string|object $class
     *
     * @throws \Exception if extension class does not implement either Dynamic or Basic interface
     */
    protected function validateClassImplementation($class)
    {
        $str_class = is_string($class);

        $valid_implementation = (is_a($class, $this->basic_interface, $str_class)
                                    || is_a($class, $this->dynamic_interface, $str_class));

        if (!$valid_implementation) {
            throw new \Exception('Class must implement either '
                                    . $this->basic_interface . ' or ' . $this->dynamic_interface);
        }
    }

    /**
     * Get the object whether it's a string or already instantiated
     *
     * @param \League\CLImate\TerminalObject\Router\RouterInterface $router
     * @param string $name
     * @param array $arguments
     *
     * @return \League\CLImate\TerminalObject\Dynamic\DynamicTerminalObjectInterface|\League\CLImate\TerminalObject\Basic\BasicTerminalObjectInterface
     */
    protected function getObject($router, $name, $arguments)
    {
        $obj = $router->path($name);

        if (is_string($obj)) {
            $obj = (new \ReflectionClass($obj))->newInstanceArgs($arguments);
        }

        if (method_exists($obj, 'arguments')) {
            call_user_func_array([$obj, 'arguments'], $arguments);
        }

        return $obj;
    }

    /**
     * Determine which type of router we are using and return it
     *
     * @param string $name
     *
     * @return \League\CLImate\TerminalObject\Router\RouterInterface|null
     */
    protected function getRouter($name)
    {
        if ($this->basic->exists($name)) {
            return $this->basic;
        }

        if ($this->dynamic->exists($name)) {
            return $this->dynamic;
        }
    }

    /**
     * Set the settings property
     *
     * @param  \League\CLImate\Settings\Manager $settings
     *
     * @return Router
     */
    public function settings(Manager $settings)
    {
        $this->settings = $settings;

        return $this;
    }
}
