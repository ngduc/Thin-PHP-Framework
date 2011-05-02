<?php
/** 
 * Thin PHP Framework (TPF) 2011 http://thinphp.com
 *
 * Licensed under TPF License at http://bit.ly/TPFLicense
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2011, Thin PHP Framework Team
 * @link          http://thinphp.com
 * @package       app
 * @license       TPF License http://bit.ly/TPFLicense
 */
	defined('BASE') or exit('Direct script access is not allowed!');	

	define('BASECTL', BASE.'/app/controller');
	define('BASEVIEW', BASE.'/app/smarty_view');
	define('BASEEXT', BASE.'/app/ext');
	
	require_once BASE.'/app/constants.php';
	
	require_once BASE.'/conf/app_config.php';
	require_once BASE.'/conf/ext_mapping.php';
	require_once BASE.'/conf/uri_mapping.php';
	require_once BASE.'/conf/lang.php';
	
	require_once BASE.'/lib/thinphp_util/includes.php';
	
	require_once BASE.'/lib/smarty/Smarty.class.php';
	
	require_once BASE.'/app/cache/base/SysCache.php';
	require_once BASE.'/app/core/log/Logger.php';
	
	require_once BASE.'/app/controller/base/BaseController.php';
	require_once BASE.'/app/controller/MainController.php';
	
	date_default_timezone_set($app_i['timezone']);
