<?php
/**
 * Thin PHP Framework (TPF) 2011-2012 http://thinphp.com
 * @package       app.cache.base
 * @license       TPF License http://bit.ly/TPFLicense
 */
defined('BASE') or exit('No direct script access allowed!');
require_once 'BaseCache.php';

class CApcCache extends BaseCache
{	
	private static $_initialized;	// singleton memcache

	/**
	 * Constructor	 
	 */ 
	public function __construct()
	{
		parent::__construct('mymc');
		
		if ( !isset(self::$_initialized) ) // init static var (once)
		{			
			if (extension_loaded('apc')) {
				self::$_initialized = true;
			} else {
				throw new Exception('APC extension is required!');
			}
		}
	}

	// ================== IMPLEMENT BASE FUNCTIONS ================== //	
	
	protected function getEntry($id)
	{		
		return (self::$_initialized ? apc_fetch($id) : false);
	}
	
	protected function setEntry($id, $value, $lifeinsecs=0)
	{		
		return (self::$_initialized ? apc_store($id, $value, $lifeinsecs) : false);
	}
	
	protected function delEntry($id)
	{
		return (self::$_initialized ? apc_delete($id) : false);
	}
}
