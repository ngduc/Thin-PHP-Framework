<?php
/** 
 * Thin PHP Framework (TPF) 2011 http://thinphp.com
 *
 * Licensed under TPF License at http://bit.ly/TPFLicense
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2011, Thin PHP Framework Team
 * @link          http://thinphp.com
 * @package       app.core.log
 * @license       TPF License http://bit.ly/TPFLicense
 */
defined('BASE') or exit('No direct script access allowed!');
require_once BASE.'/app/core/log/Log.php';

class Logger
{
	static $settings;

	public static function getLogger($name)
	{
		global $log_i;
		self::$settings = $log_i;

		$newlog = new Log($name, self::$settings['log_file']);
		return $newlog;
	}
	
	public static function getFileLogger($name, $filePath)
	{
		global $log_i;
		self::$settings = $log_i;

		$newlog = new Log($name, $filePath);
		return $newlog;
	}
}
