<?php

namespace League\CLImate;

use Psr\Log\LoggerInterface;

class CLImateLogger extends CLImate implements LoggerInterface
{
    public function __construct()
    {
        parent::__construct();
        $this->style->addCommand('emergency', 'red', 'bold');
        $this->style->addCommand('alert', 'red');
        $this->style->addCommand('critical', 'red');
        $this->style->addCommand('error', 'light_magenta');
        $this->style->addCommand('warning', 'yellow');
        $this->style->addCommand('info', 'cyan');
        $this->style->addCommand('success', 'green');
        $this->style->addCommand('notice', 'light_cyan');
        $this->style->addCommand('debug', 'dark_gray');
    }

    /**
     * System is unusable.
     *
     * @param string $message
     * @param array $context
     * @return null
     */
    public function emergency($message, array $context = array())
    {
        return $this->log(__FUNCTION__, $message, $context);
    }

    /**
     * Action must be taken immediately.
     *
     * Example: Entire website down, database unavailable, etc. This should
     * trigger the SMS alerts and wake you up.
     *
     * @param string $message
     * @param array $context
     * @return null
     */
    public function alert($message, array $context = array())
    {
        return $this->log(__FUNCTION__, $message, $context);
    }

    /**
     * Critical conditions.
     *
     * Example: Application component unavailable, unexpected exception.
     *
     * @param string $message
     * @param array $context
     * @return null
     */
    public function critical($message, array $context = array())
    {
        return $this->log(__FUNCTION__, $message, $context);
    }

    /**
     * Runtime errors that do not require immediate action but should typically
     * be logged and monitored.
     *
     * @param string $message
     * @param array $context
     * @return null
     */
    public function error($message, array $context = array())
    {
        return $this->log(__FUNCTION__, $message, $context);
    }

    /**
     * Exceptional occurrences that are not errors.
     *
     * Example: Use of deprecated APIs, poor use of an API, undesirable things
     * that are not necessarily wrong.
     *
     * @param string $message
     * @param array $context
     * @return null
     */
    public function warning($message, array $context = array())
    {
        return $this->log(__FUNCTION__, $message, $context);
    }

    /**
     * Normal but significant events.
     *
     * @param string $message
     * @param array $context
     * @return null
     */
    public function notice($message, array $context = array())
    {
        return $this->log(__FUNCTION__, $message, $context);
    }

    /**
     * Interesting events.
     *
     * Example: User logs in, SQL logs.
     *
     * @param string $message
     * @param array $context
     * @return null
     */
    public function info($message, array $context = array())
    {
        return $this->log(__FUNCTION__, $message, $context);
    }

    /**
     * Detailed debug information.
     *
     * @param string $message
     * @param array $context
     * @return null
     */
    public function debug($message, array $context = array())
    {
        return $this->log(__FUNCTION__, $message, $context);
    }

    /**
     * Logs with an arbitrary level.
     *
     * @param mixed $level
     * @param string $message
     * @param array $context
     * @return null
     */
    public function log($level, $message, array $context = array())
    {
        $context = empty($context) ? '' : json_encode($context);
        call_user_func_array("parent::{$level}", array($message . $context));
    }

}