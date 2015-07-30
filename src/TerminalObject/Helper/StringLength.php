<?php

namespace League\CLImate\TerminalObject\Helper;

trait StringLength
{
    /**
     * Tags the should not be ultimately considered
     * when calculating any string lengths
     *
     * @var array $ignore_tags
     */
    protected $ignore_tags = [];

    /**
     * Set the ignore tags property
     */
    protected function setIgnoreTags()
    {
        if (!count($this->ignore_tags)) {
            $this->ignore_tags = array_keys($this->parser->tags->all());
        }
    }

    /**
     * Determine the length of the string without any tags
     *
     * @param  string  $str
     *
     * @return integer
     */
    protected function lengthWithoutTags($str)
    {
        $this->setIgnoreTags();

        return mb_strwidth($this->withoutTags($str), 'UTF-8');
    }

    /**
     * Get the string without the tags that are to be ignored
     *
     * @param  string $str
     *
     * @return string
     */
    protected function withoutTags($str)
    {
        $this->setIgnoreTags();

        return str_replace($this->ignore_tags, '', $str);
    }

    /**
     * Apply padding to a string
     *
     * @param string $str
     * @param string $final_length
     * @param string $padding_side
     *
     * @return string
     */
    protected function pad($str, $final_length, $padding_side = 'right')
    {
        $padding = $final_length - $this->lengthWithoutTags($str);

        if ($padding_side == 'left') {
            return str_repeat(' ', $padding) . $str;
        }

        return $str . str_repeat(' ', $padding);
    }

    /**
     * Apply padding to an array of strings
     *
     * @param  array $arr
     * @param  integer $final_length
     * @param string $padding_side
     *
     * @return array
     */
    protected function padArray($arr, $final_length, $padding_side = 'right')
    {
        foreach ($arr as $key => $value) {
            $arr[$key] = $this->pad($value, $final_length, $padding_side);
        }

        return $arr;
    }

    /**
     * Find the max string length in an array
     *
     * @param array $arr
     * @return int
     */
    protected function maxStrLen(array $arr)
    {
        return max($this->arrayOfStrLens($arr));
    }

    /**
     * Get an array of the string lengths from an array of strings
     *
     * @param array $arr
     * @return array
     */
    protected function arrayOfStrLens(array $arr)
    {
        return array_map([$this, 'lengthWithoutTags'], $arr);
    }
}
