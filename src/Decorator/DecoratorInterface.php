<?php

namespace CLImate\Decorator;

interface DecoratorInterface
{
	public function add($key, $value);

	public function defaults();

	public function get($val);

	public function set($val);

	public function all();

	public function current();

	public function reset();
}
