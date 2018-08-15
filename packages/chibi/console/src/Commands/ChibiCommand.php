<?php
namespace Chibi\Console\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;

use Chibi\Console\Interfaces\CommandInterface;

abstract class ChibiCommand extends Command implements CommandInterface {

	protected $input;
	protected $output;
	/**
	 * [configure description]
	 * @return [type] [description]
	 */
	public function configure()
	{
		$this->setName($this->name)
			  ->setDescription($this->description);

		$this->mapArguments();
		$this->mapOptions();
	}
	/**
	 * [configure description]
	 * @return [type] [description]
	 */
	public function execute(InputInterface $input, OutputInterface $output)
	{
		$this->input = $input;
		$this->output = $output;
		$this->fire();
	}
	/**
	 * [mapArguments description]
	 * @return [type] [description]
	 */
	protected function mapArguments () 
	{
		if (!empty($this->arguments)) {
			foreach ($this->arguments as $key => $description) {
				$argName = explode('|',$key);
				
				$this->addArgument(
					$argName[0],
					$this->isRequire($argName) ? InputArgument::REQUIRED : InputArgument::OPTIONAL,
					$description
				);
			}
		}
	}
	/**
	 * [mapOptions description]
	 * @return [type] [description]
	 */
	protected function mapOptions () 
	{
		if (!empty($this->options)) {
			foreach ($this->options as $key => $description) {
				$opName = explode('|',$key);

				$this->addOption(
			        $opName[0],
			        null,
			        $this->isRequire($opName) ? InputOption::VALUE_REQUIRED : InputOption::VALUE_OPTIONAL,
			        $description,
			        1
			    );
			}
		}
	}
	/**
	 * [isRequire description]
	 * @param  [type]  $arr [description]
	 * @return boolean      [description]
	 */
	private function isRequire($arr) 
	{
		return isset($arr[1]) && $arr[1] == 'required';
	}
	/**
	 * [configure description]
	 * @return [type] [description]
	 */
	public function hasArgument($argumentName)
	{
		return $this->input()->hasArgument($argumentName);
	}
	/**
	 * [configure description]
	 * @return [type] [description]
	 */
	public function getArgument($argumentName)
	{
		return $this->input()->getArgument($argumentName);
	}
	/**
	 * [configure description]
	 * @return [type] [description]
	 */
	public function getArguments()
	{
		return $this->input()->getArguments();
	}
	/**
	 * [configure description]
	 * @return [type] [description]
	 */
	public function getOption($optionName)
	{
		return $this->input()->getOption($optionName);
	}
	/**
	 * [configure description]
	 * @return [type] [description]
	 */
	public function getOptions()
	{
		return $this->input()->getOptions();
	}
	/**
	 * [configure description]
	 * @return [type] [description]
	 */
	public function setOption($optionName,$value)
	{
		return $this->input()->setOption($optionName, $value);
	}
	/**
	 * [configure description]
	 * @return [type] [description]
	 */
	public function hasOption()
	{
		return $this->input()->hasOption($optionName);
	}
	/**
	 * [configure description]
	 * @return [type] [description]
	 */
	public function input()
	{
		return $this->input;
	}
	/**
	 * [configure description]
	 * @return [type] [description]
	 */
	public function output()
	{
		return $this->output;
	}

	public function comment($message)
	{
		$this->output()->writeln($message);
	}
}
