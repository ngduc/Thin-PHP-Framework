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
require_once 'CApcCache.php';
require_once 'CMemCache.php';

abstract class CacheFactory
{
	// Singleton pattern
	private static $_apc;
	private static $_memcache;
	
	public static function initCache()
	{
		global $app_i;
		switch ($app_i['cache'])
		{
			case CC_NOCACHE:
				return null;
			case CC_APC:
				if ( !isset(self::$_apc) )
				{
					self::$_apc = new CApcCache();
					return self::$_apc;
				}
				return self::$_apc;
			case CC_MEMCACHE:
				if ( !isset(self::$_memcache) )
				{
					self::$_memcache = new CMemCache();
					return self::$_memcache;
				}
				return self::$_memcache;
		}
		return null;
	}
}
?>