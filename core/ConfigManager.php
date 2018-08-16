<?php

namespace Kolores;

use Kolores\Config\Config;

class ConfigManager 
{
	public function __construct(Config $config)
	{
		$container = app()->getContainer();
		$container->config = $config;
	}
}