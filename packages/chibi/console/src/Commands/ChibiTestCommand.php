<?php

namespace Chibi\Console\Commands;

class ChibiTestCommand extends ChibiCommand
{
	/**
	 * Hold command name
	 * @var string
	 */
	protected $name = "test";

	/**
	 * Hold command description
	 * @var string
	 */
	protected $description = "test description";

	/**
	 * Hold command arguments
	 * @var array
	 */
	protected $arguments = [
		'name' => 'this test name argument'
	];

	/**
	 * Hold command options
	 * @var array
	 */
	protected $options = [
		'check' => 'this is a --check option'
	];
	
	/**
	 * @inheritdoc
	 */
	public function fire() 
	{
		$this->comment($this->name.'::command is fired');
	}
}