<?php

namespace League\CLImate\TerminalObject\Router;

use League\CLImate\Util\OutputImporter;

class BasicRouter extends BaseRouter implements RouterInterface
{
    use OutputImporter;

    /**
     * Get the full path for a terminal object class
     *
     * @param  string $class
     * @return string
     */
    public function path($class)
    {
        return $this->getPath($this->shortName($class));
    }

    /**
     * Execute a basic terminal object
     *
     * @param League\CLImate\TerminalObject $obj
     */
    public function execute($obj)
    {
        $results = $obj->result();

        if (!is_array($results)) {
            $results = [$results];
        }

        foreach ($results as $result) {
            if ($obj->sameLine()) {
                $this->output->sameLine();
            }

            if ($obj->hasAnsiSupport()) {
                $result = $obj->getParser()->apply($result);
            } else {
                $result = $obj->getParser()->ignore($result);
            }

            $this->output->write($result);
        }
    }
}
