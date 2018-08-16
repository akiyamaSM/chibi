<?php
namespace Chibi\Console\Interfaces;

interface CommandInterface {
	/**
	 * fire this function exececuted when symfony command execute triggred
	 * @return void
	 */
	public function fire();
}