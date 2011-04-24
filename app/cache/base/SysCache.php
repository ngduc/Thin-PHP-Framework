<?php
/** 
 * Thin PHP Framework (TPF) 2011 http://thinphp.com
 *
 * Licensed under TPF License at http://bit.ly/TPFLicense
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2011, Thin PHP Framework Team
 * @link          http://thinphp.com
 * @package       app.cache.base
 * @license       TPF License http://bit.ly/TPFLicense
 */
defined('BASE') or exit('No direct script access allowed!');
require_once 'CacheFactory.php';

abstract class SysCache
{	
	public static $c; // cache
	
	public static function init()
	{		
		self::$c = CacheFactory::initCache();
		
		if (self::$c != null) return true;
		return false;
	}
	
	public static function getFloodLimit()
	{		
		if (SysCache::init()) {
			global $app_i;
			return $app_i['flood_limit'];
		}
		return 0;
	}
	
	public static function adjustLastRequestTime()
	{
		// adjust Last Request Time to prevent 'flooding' error
		// (for example: requests for Form Validation & Form Submit happen too fast!)
		if (SysCache::init()) {
			SysCache::$c->set($_SERVER['REMOTE_ADDR'].'reqtime', microtime(true)-2.0, 15);
		}
	}
}
