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
		
		if ($route == '/') {
			$this->_cPath = 'controller';
			$this->_cName = 'Home';
			$this->_cParams = null;
		} else {
			// get ControllerName and its Parameters from URI
			list($this->_cPath, $this->_cName, $this->_cParams) = BaseController::parseRoute($route);
		}
	}

	public function handle($params)
	{
		if ($this->_cName == null) // above parseRoute() failed => run Default Controller (if specified):
		{
			global $app_i;
			$def = trim($app_i['default_controller']);
			if ($def != '' && file_exists(BASE.$def)) {
				require_once BASE.$def;
				$ctr = new DefaultController();
				$ctr->handle($this->_cParams);
				$this->log->debug('Invalid URI. DefaultController called.');
				return;
			}
		}
		
		// URI parsed OK!		
		$fullpath = '/app/'.$this->_cPath.'/'.$this->_cName.'.php';
		$this->log->debug('handle() route: '.$fullpath);

		$fullpath = BASE.$fullpath;

		if (file_exists($fullpath))
		{
     		// load parsed Controller
			require_once $fullpath;
			$ctr = new $this->_cName();
			$ctr->handle($this->_cParams);
		}
		else {
			die('MainController: Error: Controller not found!');
		}
		$this->log->debug('handle() ended');
	}

	public function view() { } // MainController does not need view()
}