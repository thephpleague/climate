<?php

namespace League\CLImate\TerminalObject\Router;

abstract class BaseRouter implements RouterInterface
{
    protected $extensions = [];

    /**
     * Add a custom extension to CLImate
     *
     * @param string $key
     * @param string $class
     */
    public function addExtension($key, $class)
    {
        $this->extensions[$key] = $class;
    }

    /**
     * Get the full path for the class based on the key
     *
     * @param string $class
     *
     * @return string
     */
    public function path($class)
    {
        return $this->getExtension($class) ?: $this->getPath($this->shortName($class));
    }

    /**
     * Determines if the requested class is a
     * valid terminal object class
     *
     * @param  string  $class
     *
     * @return boolean
     */
    public function exists($class)
    {
        $class = $this->path($class);

        return (is_object($class) || class_exists($class));
    }

    /**
     * Get the full path for the terminal object class
     *
     * @param  string $class
     *
     * @return string
     */
    protected function getPath($class)
    {
        return 'League\CLImate\TerminalObject\\' . $this->pathPrefix() . '\\' . $class;
    }

    /**
     * Get an extension by its key
     *
     * @param string $key
     *
     * @return string|false Full class path to extension
     */
    protected function getExtension($key)
    {
        if (array_key_exists($key, $this->extensions)) {
            return $this->extensions[$key];
        }

        return false;
    }

    /**
     * Get the class short name
     *
     * @param string $name
     *
     * @return string
     */
    protected function shortName($name)
    {
        $name = str_replace('_', ' ', $name);
        $name = ucwords($name);

        return str_replace(' ', '', $name);
    }
}
