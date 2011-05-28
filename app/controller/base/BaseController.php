<?php
/**
 * Thin PHP Framework (TPF) 2011 http://thinphp.com
 *
 * Licensed under TPF License at http://bit.ly/TPFLicense
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2011, Thin PHP Framework Team
 * @link          http://thinphp.com
 * @package       app.controller.base
 * @license       TPF License http://bit.ly/TPFLicense
 */
defined('BASE') or exit('No direct script access allowed!');
require_once BASE.'/app/controller/base/IController.php';
require_once BASE.'/app/constants.php';

abstract class BaseController
{
	protected $smarty;
	protected $params;

	function __construct()
	{
		$this->smarty = new Smarty();

		// configure Smarty with Relative Paths (from '/dispatcher.php')		
		$this->smarty->setTemplateDir('app/view');
		$this->smarty->setConfigDir  ('app/conf/smarty_config');
		$this->smarty->setCacheDir   ('app/appdata/smarty_cache'); // writable
		$this->smarty->setCompileDir ('app/appdata/smarty_compiled'); // writable
	}
	
	// ================================ PRIVATE //

	/**
	 * Insert $lang to use in a View & include tracking code.
	 */
	private function processSmartyView($v)
	{
		global $app_i, $lang;
		$viewDir = currentViewDir();

		$v->assign('lang', $lang[$viewDir]);

		if ( !isLocalhost() && file_exists(BASEVIEW.'/'.$viewDir.'/tracking_code.html')) {
			$v->assign('inc_tracking_code', 'file:/'.BASEVIEW.'/'.$viewDir.'/tracking_code.html'); // abs path so Extensions find it too.
		} else {
			$v->assign('inc_tracking_code', 'file:'.BASEVIEW.'/blank.html');
		}
	}
	
	// ================================ PUBLIC //
	
	public function handle($params)
	{
		// check flooding using SysCache before handle Controller
		if (SysCache::$floodingChecked == false && SysCache::getFloodLimit() > 0) {
			$ip = $_SERVER['REMOTE_ADDR'];
			if (isFlooding( SysCache::$c->get('reqtime'.$ip) )) die('flooding!');
			SysCache::$c->set('reqtime'.$ip, microtime(true), 15);
			SysCache::$floodingChecked = true; // check only once per visitor
		}
		
		// call Controller
		$this->params = $params;		
		$this->view();
	}
	
	public function isValidating()
	{		
		if (isset($this->params[0]) && trim($this->params[0])=='validate') return true;
		return false;
	}
	
	public function isPosting()
	{
		if (isset($_POST) && count($_POST) >0) return true;
		return false;
	}
	
	public function display($v, $viewfile)
	{
		$this->processSmartyView($v);

		// customize your view here...
		$v->display($viewfile);
	}

	// ================================ TO BE IMPLEMENTED IN EXTENDING CLASS //
	
	public function validate($retType)
	{
		SysCache::adjustLastRequestTime();
	}
	
	public function processPost()
	{
		// validate again before processing
		$rets = $this->validate(RT_NONE);
		if (isset($rets) && $rets != null) die('Error: invalid data! ');
	}
	
	/**
	 * Main entry function of a Controller
	 * Must be implemented!
	 */
	abstract public function view();

	// ================================ STATIC FUNCTIONS //
	
	/**
	 * Process URI to know which controller to load
	 * @return an array: controller Path, Name, Params
	 */
	public static function parseRoute($route)
	{
		if (strpos($route, '/dispatcher.php') !== false) {
			return array('controller', 'Home', '');
		}
		$params = null;
				
		// first, check if URI matched with Custom URI Mappings in 'conf/uri_mapping.php'
		$mpArr = parseUri($route);
		if ($mpArr != null)
		{
            if (isset($mpArr[2]) != null) {
                return array($mpArr[0], $mpArr[1], $mpArr[2]); // path, name, params
            }
            else {
                return array($mpArr[0], $mpArr[1], null); // path, name
            }
		}
        die('ERROR: Invalid URL!');
	}
	
	/**
	 * Call a Controller, Extension, etc. in your code
	 * @return Controler's output (from its handle() function)
	 */
	public static function callController($ctrPath, $className, $params)
	{
		$fullpath = $ctrPath.'/'.$className.'.php';

		if (file_exists($fullpath))
		{
			ob_start();
     		// load extension
			require_once $fullpath;
			$ctr = new $className();
			$ctr->handle($params);

			$ret = ob_get_contents();
			ob_end_clean();
			return $ret;
		}
		return 'Ext not found!';
	}
}