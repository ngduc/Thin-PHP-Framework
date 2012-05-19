<?php
/**
 * Thin PHP Framework (TPF) 2011-2012 http://thinphp.com
 * @package       app.cache.base
 * @license       TPF License http://bit.ly/TPFLicense
 */
defined('BASE') or exit('No direct script access allowed!');
require_once 'BaseCache.php';

class CMemCache extends BaseCache
{	
	private static $_cache;	// singleton memcache
		
	/**
	 * Constructor	 
	 */ 
	public function __construct()
	{
		parent::__construct('mymc');
		
		if ( !isset(self::$_cache) ) // init static var (once)
		{
			// load config file
			global $memcache_i;		
			self::$_cache = new Memcache;
			self::$_cache->connect($memcache_i['server'], $memcache_i['port']);
		}
	}

	// ================== IMPLEMENT BASE FUNCTIONS ================== //	
	
	protected function getEntry($id)
	{		
		return (self::$_cache ? self::$_cache->get($id) : false);
	}
	
	protected function setEntry($id, $value, $lifeinsecs=0)
	{
		return (self::$_cache ? self::$_cache->set($id, $value, MEMCACHE_COMPRESSED, $lifeinsecs) : false);
	}
	
	protected function delEntry($id)
	{
		return (self::$_cache ? self::$_cache->set($id, 0) : false); // delete an entry right away (set timeout = 0)
	}
}
