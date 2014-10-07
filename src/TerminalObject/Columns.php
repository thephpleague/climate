<?php

namespace League\CLImate\TerminalObject;

class Columns extends BaseTerminalObject
{
    use Helper\StringLength;

    /**
     * Number of columns
     *
     * @var integer $count
     */

    protected $count;

    /**
     * Data to columnize
     *
     * @var array $data
     */

    protected $data;

    public function __construct($data, $count = null)
    {
        $this->data  = $data;
        $this->count = $count;
    }

    /**
     * Calculate the number of columns organize data
     *
     * @return array
     */

    public function result()
    {
        $column_width = $this->getColumnWidth($this->data);
        $max_rows     = $this->getMaxRows($column_width);

        $this->data   = array_chunk($this->data, $max_rows);

        $column_widths = $this->getColumnWidths();

        $output = [];

        for ($i = 0; $i < $max_rows; $i++) {
            $output[] = $this->getRow($i, $column_widths);
        }

        return $output;
    }

    /**
     * Get the row of data
     *
     * @param integer $key
     * @param integer $column_width
     * @return string
     */

    protected function getRow($key, $column_widths)
    {
        $row = [];

        for ($j = 0; $j < $this->count; $j++) {
            if (array_key_exists($key, $this->data[$j])) {
                $row[] = $this->pad($this->data[$j][$key], $column_widths[$j]);
            }
        }

        return implode('', $row);
    }

    /**
     * Get the standard column width
     *
     * @param array $data
     * @return integer
     */

    protected function getColumnWidth($data)
    {
        $column_width = array_map([$this, 'lengthWithoutTags'], $data);

        // Return the maximum width plus a buffer
        return max($column_width) + 5;
    }

    /**
     * Get an array of each column's width
     *
     * @return array
     */

    protected function getColumnWidths()
    {
        $column_widths = [];

        for ($i = 0; $i < $this->count; $i++) {
            $column_widths[] = $this->getColumnWidth($this->data[$i]);
        }

        return $column_widths;
    }

    /**
     * Set the count property
     *
     * @param integer $column_width
     */

    protected function setCount($column_width)
    {
        $this->count = floor($this->util->dimensions->width() / $column_width);
    }

    /**
     * Get the number of rows per column
     *
     * @param integer $column_width
     * @return integer
     */

    protected function getMaxRows($column_width)
    {
        if (!$this->count) $this->setCount($column_width);

        return ceil(count($this->data) / $this->count);
    }
}
