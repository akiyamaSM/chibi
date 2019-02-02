<?php

namespace Chibi;

use Chibi\Config\Config;

class ConfigManager 
{
	public function __construct(Config $config)
	{
		$container = app()->getContainer();
		$container->config = $config;
	}
}