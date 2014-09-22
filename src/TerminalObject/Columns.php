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
        $column_width = $this->getColumnWidth();
        $max_rows     = $this->getMaxRows($column_width);

        $this->data   = array_chunk($this->data, $max_rows);

        $output = [];

        for ($i = 0; $i < $max_rows; $i++) {
            $output[] = $this->getRow($i, $column_width);
        }

        return $output;
    }

    /**
     * Get the row of data
     *
     * @param integer $key
     * @param integer $column_width
     */

    protected function getRow($key, $column_width)
    {
        $row = [];

        for ($j = 0; $j < $this->count; $j++) {
            if (array_key_exists($key, $this->data[$j])) {
                $row[] = $this->pad($this->data[$j][$key], $column_width);
            }
        }

        return implode('', $row);
    }

    /**
     * Get the standard column width
     *
     * @return integer
     */

    protected function getColumnWidth()
    {
        $column_width = array_map([$this, 'lengthWithoutTags'], $this->data);

        // Return the maximum width plus a buffer
        return max($column_width) + 5;
    }

    /**
     * Get the number of rows per column
     *
     * @param integer $column_width
     *
     * @return integer
     */

    protected function getMaxRows($column_width)
    {
        // If a count wasn't specified, determine based on terminal width
        if (!$this->count) {
            $terminal_width = exec('tput cols');
            $this->count    = floor($terminal_width / $column_width);
        }

        return ceil(count($this->data) / $this->count);
    }
}
