<?php
/** 
 * Thin PHP Framework (TPF) 2011 http://thinphp.com
 *
 * Licensed under TPF License at http://bit.ly/TPFLicense
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2011, Thin PHP Framework Team
 * @link          http://thinphp.com
 * @package       app.model.base
 * @license       TPF License http://bit.ly/TPFLicense
 */
defined('BASE') or exit('Direct script access is not allowed!');
require_once BASE.'/app/model/base/driver/DBPdoMysql.php';
require_once BASE.'/app/model/base/driver/DBPdoSqlite.php';

abstract class DBFactory
{
	// Singleton pattern.
	static $dbh;
	
	/**
	 * @return Database Handler
	 */
	public static function getDBHandler()
	{
		global $db_i;
		$dbenv = $db_i[$db_i['env']];
		
		switch ($dbenv['dbdriver'])
		{
			case DB_PDO_MYSQL:
				if ( !isset(self::$dbh) )
				{
					$ret = new DBPdoMysql($dbenv);
					self::$dbh = $ret->getDBHandler();					
					return self::$dbh;
				}
				return self::$dbh;
			case DB_PDO_SQLITE:
				if ( !isset(self::$dbh) )
				{
					$ret = new DBPdoSqlite($dbenv);
					self::$dbh = $ret->getDBHandler();					
					return self::$dbh;
				}
				return self::$dbh;
		}
		return null;
	}
}
?>