<?php

namespace League\CLImate\Util\Reader;

interface ReaderInterface
{
    /**
     * @return string
     */
    public function line();

    /**
     * @return string
     */
    public function multiLine();

    /**
     * @return bool
     */
    public function isIteractive(): bool;

    /**
     * @param bool $interactive
     *
     * @return void
     */
    public function setInteractive(bool $interactive): void;
}
