<?php

namespace CLImate\Decorator;

class BackgroundColor extends Color
{
	const ADD = 10;

    public function get($val)
    {
    	$color = parent::get($val);

    	if ($color) {
    		$color += self::ADD;
    	}

    	return $color;
    }

    public function set($val)
    {
        $val = str_replace('background_', '', $val);

        return parent::set($val);
    }

    public function all()
    {
    	$colors = [];

    	foreach ($this->colors as $color => $code) {
    		$colors['background_' . $color] = $code + self::ADD;
    	}

        return $colors;
    }
}
