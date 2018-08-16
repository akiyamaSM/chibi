<?php

namespace Chibi\Console;

use Symfony\Component\Console\Application as SymfonyApplication; 

class Application extends SymfonyApplication 
{	
	/**
	 * [$app description]
	 * @var [type]
	 */
	protected static $app;

	/**
	 * [$app description]
	 * @var [type]
	 */
	protected static $commands = [];

	/**
	 * [$app description]
	 * @var [type]
	 */
	protected static $baseCommands = [
		\Chibi\Console\Commands\ChibiTestCommand::class
	];

	/**
	 * [console description]
	 * @param  array  $newCommands [description]
	 * @return [type]              [description]
	 */
	public static function console($newCommands = []) 
	{
		$app = new SymfonyApplication();
		self::mapCommands($app,$newCommands);
		return $app->run();
	}
	
	/**
	 * [mapCommands description]
	 * @param  [type] $app         [description]
	 * @param  [type] $newCommands [description]
	 * @return [type]              [description]
	 */
	protected function mapCommands($app,$newCommands) 
	{
		foreach (self::$baseCommands as $command) {
			$app->add(new $command());
		}
		foreach ($newCommands as $command) {
			$app->add(new $command());
		}
	}
}