<?php

namespace Chibi\Console\Commands;

class ChibiTestCommand extends ChibiCommand
{
	/**
	 * [$name description]
	 * @var string
	 */
	protected $name = "test";
	/**
	 * [$description description]
	 * @var string
	 */
	protected $description = "test description";
	/**
	 * [$arguments description]
	 * @var [type]
	 */
	protected $arguments = [
		'name' => 'this is a --check description'
	];
	/**
	 * [$options description]
	 * @var [type]
	 */
	protected $options = [
		'check' => 'this is a --check-opt description'
	];
	/**
	 * [fire description]
	 * @return [type] [description]
	 */
	public function fire() {
		$this->comment($this->name.'::command is fired');
	}
}