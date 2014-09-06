<?php

namespace CLImate\Decorator;

abstract class BaseDecorator implements DecoratorInterface
{
	protected $defaults = [];

	protected $current = [];

	public function __construct()
	{
		$this->defaults();
	}

	public function defaults()
	{
		foreach ($this->defaults as $name => $code) {
			$this->add($name, $code);
		}
	}

	public function reset()
	{
		$this->current = [];
	}

	public function current()
	{
		return $this->current;
	}
}
