<?php

namespace Kolores\Config;

class Config implements \ArrayAccess
{
	/**
	 * [$configPath description]
	 * @var string
	 */
	const CONFIG_PATH = 'etc';
	const EXT_EXAMPLE = 'example';
	
	/**
	 * [$config description]
	 * @var array
	 */
	protected $configs = [];

	public function __construct() {
		$this->load();
	}

	/**
	 * [load description]
	 * @return [type] [description]
	 */
	public function load() 
	{	
		$this->mapConfigDir(CORE_PATH . DS . self::CONFIG_PATH);
		$this->mapConfigDir(APP_PATH . DS . self::CONFIG_PATH);
	}

	/**
	 * [mapConfigDir description]
	 * @param  [type] $dirPath [description]
	 * @return [type]          [description]
	 */
	protected function mapConfigDir($dirPath)
	{
		if (is_dir($dirPath)) {
			$directory = new \DirectoryIterator($dirPath);
			foreach ($directory as $file) {
				if (!$file->isDot() && $file->getExtension() != self::EXT_EXAMPLE) {
					$this->setConfig($file);
				}
			}
		}
	}

	/**
	 * [setConfig description]
	 * @param [type] $file [description]
	 */
	protected function setConfig($file)
	{
		//@todo : file parser ( json, yaml, ...)
		$filename = $file->getBasename('.php');
		if (!isset($this->configs[$filename])) {
			$this->configs[$filename] = [];
		}
		$this->configs[$filename] = array_replace_recursive($this->configs[$filename],include($file->getPathname()));
	}

	/**
     * Check if offset exists
     *
     * @param string $offset
     * @return boolean
     */
    public function offsetExists($offset)
    {
        return isset($this->configs[$offset]);
    }

    /**
     * Get the offset
     *
     * @param string $offset
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return isset($this->configs[$offset]) ? $this->configs[$offset] : null;
    }

    /**
     * Set the offset
     *
     * @param string $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value)
    {
        $this->configs[$offset] = $value;
    }

    /**
     * Unset the offset
     *
     * @param type $offset
     */
    public function offsetUnset($offset)
    {
        unset($this->configs[$offset]);
    }

}