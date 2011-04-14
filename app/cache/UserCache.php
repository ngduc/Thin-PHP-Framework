<?php
defined('BASE') or exit('No direct script access allowed!');
require_once BASE.'/app/cache/base/CApcCache.php';
require_once BASE.'/app/cache/base/CMemCache.php';
require_once BASE.'/app/model/base/DAOs.php';

abstract class UserCache
{	
	public static $cache;
	public static $dao;
	
	public static function init()
	{
		self::$cache = new CMemCache(); // set your favourite cache here
		self::$dao = DAOs::getDAO('UserDAO');
	}
	
	public static function findAll()
	{
		if ( !isset(self::$cache)) self::init();
		$cid = 'cachedAllUsers';
		
		$rows = self::$cache->get($cid);
		if ($rows == false) {
			// not cached yet. Then, load from DB & cache it.
			$rows = self::$dao->findAll();
			self::$cache->set($cid, $rows, 5);
			return $rows;
		}
		else {
			// echo 'cached!<p/>';
			return $rows;
		}
	}
}
?>