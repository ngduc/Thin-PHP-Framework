<?php
/** 
 * Thin PHP Framework (TPF) 2011 http://thinphp.com
 *
 * Licensed under TPF License at http://bit.ly/TPFLicense
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2011, Thin PHP Framework Team
 * @link          http://thinphp.com
 * @package       app.controller
 * @license       TPF License http://bit.ly/TPFLicense
 */
defined('BASE') or exit('No direct script access allowed!');

class MainController extends BaseController
{
	private $_cPath;
	private $_cName;
	private $_cParams;	
	private $log;

	public function __construct($route)
	{
		parent::__construct();
		$this->log = Logger::getLogger(__CLASS__);		
		$this->log->info('Main Controller Log');
		
		// get ControllerName and its Parameters from URI		
		list($this->_cPath, $this->_cName, $this->_cParams) = BaseController::parseRoute($route);		
	}	
	
	public function handle($params)
	{
		$fullpath = '/app/'.$this->_cPath.'/'.$this->_cName.'.php';
		$this->log->debug('handle() route: '.$fullpath);
		
		$fullpath = BASE.$fullpath;
		
		if (file_exists($fullpath))
		{
     		// load controller
			require_once $fullpath;
			$ctr = new $this->_cName();
			$ctr->handle($this->_cParams);
		}
		else {
			die('Error: invalid URL!');
		}
		$this->log->debug('handle() ended');
	}

	public function view() { } // MainController does not need view()
}
?>