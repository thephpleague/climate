<?php

namespace CLImate\TerminalObject;

use CLImate\Output;
use CLImate\Decorator\Parser;
use CLImate\Decorator\ParserImporter;
use CLImate\Settings\Manager;

class Router
{
    use ParserImporter;

    /**
     * An instance of the Settings Manager class
     *
     * @var CLImate\Settings\Manager $settings;
     */

    protected $settings;

    /**
	 * Check if the name matches an existing terminal object
	 *
	 * @param string $name
	 * @return boolean
	 */

    public function exists($name)
    {
        return ($this->isBasic($name) || $this->isDynamic($name));
    }

    /**
     * Execute a terminal object using given arguments
     *
     * @param string $name
     * @param mixed  $arguments
     */

    public function execute($name, $arguments)
    {
        $class      = $this->getClass($name);

        $reflection = new \ReflectionClass($class);
        $obj        = $reflection->newInstanceArgs($arguments);

        $obj->parser($this->parser);

        // If the object needs any settings, import them
        foreach ($obj->settings() as $obj_setting) {
            $setting = $this->settings->get($obj_setting);

            if ($setting) {
                $obj->importSetting($setting);
            }
        }

        if ($this->isBasic($name)) {
            $this->executeBasic($obj);
        } else {
            return $this->executeDynamic($obj);
        }
    }

    /**
     * Set the parser property
     *
     * @param  CLImate\Decorator\Parser      $parser
     * @return CLImate\TerminalObject\Router
     */

    public function parser(Parser $parser)
    {
        $this->parser = $parser;

        return $this;
    }

    /**
     * Set the settings property
     *
     * @param  CLImate\Settings\Manager      $settings
     * @return CLImate\TerminalObject\Router
     */

    public function settings(Manager $settings)
    {
        $this->settings = $settings;

        return $this;
    }

    /**
     * Get the full path for the terminal object class
     *
     * @param  string $class
     * @return string
     */

    protected function getPath($class)
    {
        return '\\CLImate\\TerminalObject\\' . $class;
    }

    /**
     * Get the full path for a terminal object class
     *
     * @param  string $name
     * @return string
     */

    protected function getBasicPath($name)
    {
        return $this->getPath(ucwords($name));
    }

    /**
     * Get the full path for a dynamic terminal object class
     *
     * @param  string $name
     * @return string
     */

    protected function getDynamicPath($name)
    {
        return $this->getPath('Dynamic\\' . ucwords($name));
    }

    /**
     * Get the path for the terminal object class
     *
     * @param  string $name
     * @return mixed
     */

    protected function getClass($name)
    {
        if ($this->isBasic($name)) {
            return $this->getBasicPath($name);
        } elseif ($this->isDynamic($name)) {
            return $this->getDynamicPath($name);
        }

        return null;
    }

    /**
     * Execute a basic terminal object
     *
     * @param CLImate\TerminalObject $obj
     */

    protected function executeBasic($obj)
    {
        $results = $obj->result();

        if (!is_array($results)) {
            $results = [$results];
        }

        foreach ($results as $result) {
            echo new Output($result, $this->parser);
        }
    }

    /**
     * Execute a dynamic terminal object using given arguments
     *
     * @param CLImate\TerminalObject\Dynamic $obj
     * @param CLImate\TerminalObject\Dynamic $arguments
     */

    protected function executeDynamic($obj)
    {
        $obj->parser($this->parser);

        return $obj;
    }

    /**
     * Determines if the requested class is a
     * valid basic terminal object class
     *
     * @param  string  $name
     * @return boolean
     */

    protected function isBasic($name)
    {
        return class_exists($this->getBasicPath($name));
    }

    /**
     * Determines if the requested class is a
     * valid dynamic terminal object class
     *
     * @param  string  $name
     * @return boolean
     */

    protected function isDynamic($name)
    {
        return class_exists($this->getDynamicPath($name));
    }
}
