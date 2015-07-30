<?php

namespace League\CLImate\Util;

class Helper
{
    /**
     * @param string|array $var
     *
     * @return array
     */
    public static function toArray($var)
    {
        if (!is_array($var)) {
            return [$var];
        }

        return $var;
    }

    /**
     * Flatten a multi-dimensional array
     *
     * @param array $arr
     *
     * @return array
     */
    public static function flatten(array $arr)
    {
        $flattened = [];

        array_walk_recursive($arr, function ($a) use (&$flattened) {
            $flattened[] = $a;
        });

        return $flattened;
    }

    /**
     * Convert a string to snake case
     *
     * @param string $str
     *
     * @return string
     */
    public static function snakeCase($str)
    {
        return strtolower(preg_replace('/(.)([A-Z])/', '$1_$2', $str));
    }
}
