<?php

namespace CLImate\Decorator;

class BackgroundColor extends Color
{
    /**
     * The difference to add to a foreground color code
     * to get a background color code
     *
     * @const integer ADD
     */

    const ADD = 10;

    /**
     * Get the code for the requested color
     *
     * @param  mixed $val
     * @return mixed
     */

    public function get($val)
    {
        $color = parent::get($val);

        if ($color) $color += self::ADD;
        return $color;
    }

    /**
     * Set the current background color
     *
     * @param  mixed   $val
     * @return boolean
     */

    public function set($val)
    {
        $val = str_replace('background_', '', $val);

        return parent::set($val);
    }

    /**
     * Get all of the available background colors
     *
     * @return array
     */

    public function all()
    {
        $colors = [];

        foreach ($this->colors as $color => $code) {
            $colors['background_' . $color] = $code + self::ADD;
        }

        return $colors;
    }
}
