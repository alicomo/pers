<?php

/**
 * TaskExecuter provides utility to execute a task with arguments and options
 *
 * @package    symfony
 * @subpackage tools
 * @author     Sébastien Eustace <sebastien.eustace@gmail.com>
 */

class sfTaskExecuter
{
	protected $_task = '';
	protected $_context = null;
	protected $_arguments = array();
	protected $_options = array();
	
	public function __construct($task, $arguments = array(), $options = array(), $context = null)
	{
		if (empty($task))
		{
			throw new sfException('Cannot instantiate an empty task');
		}
		
		$this->_arguments = $arguments;
		$this->_options = $options;
		
		try {
		    $this->_context = ! empty($context) ? $context : sfContext::getInstance();
		    $dispatcher = $this->_context->getEventDispatcher();
		} catch (sfException $e) {
		    $dispatcher = new sfEventDispatcher();
		}
		
		$this->_task = new $task($dispatcher, new sfFormatter());
	}
	
	/**
	 * Executes the task
	 * 
	 * @param boolean $withException whether the method should throw error
	 * @return (mixed) string|void
	 */
	public function execute($withException = false)
	{
		chdir(sfConfig::get('sf_root_dir'));
		try {
		    if (empty($withException)) {
			    return $this->_task->run($this->_arguments, $this->_options);
		    } else {
		        $this->_task->run($this->_arguments, array_merge($this->_options));
		    }
		} catch (Exception $e) {
		    return 'Error: ' . $e->getMessage() . PHP_EOL . '(File: ' .$e->getFile() . ' on line ' . $e->getLine() . ')';
		}
	}
}