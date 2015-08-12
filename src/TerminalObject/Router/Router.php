<?php

namespace League\CLImate\TerminalObject\Router;

use League\CLImate\Decorator\Parser\ParserImporter;
use League\CLImate\Settings\Manager;
use League\CLImate\Settings\SettingsImporter;
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
        $extension = new ExtensionCollection($key, $class);

        foreach ($extension->collection() as $obj_type => $collection) {
            foreach ($collection as $obj_key => $obj_class) {
                $this->{$obj_type}->addExtension($obj_key, $obj_class);
            }
        }
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
