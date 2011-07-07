<?php
/** 
 * Thin PHP Framework (TPF) 2011 http://thinphp.com
 *
 * Licensed under TPF License at http://bit.ly/TPFLicense
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2011, Thin PHP Framework Team
 * @link          http://thinphp.com
 * @package       app.model.base.mongo
 * @license       TPF License http://bit.ly/TPFLicense
 */
defined('BASE') or exit('Direct script access is not allowed!');

abstract class MongoDBFactory
{
	// Singleton pattern.
	static $dbh;
	
	/**
	 * @return Database Handler
	 */
	public static function getDBHandler()
	{
		if ( !isset(self::$dbh) )
		{
            global $mongodb_i;
            $dbname = $mongodb_i['dbname'];

			$ret = null;
			try {
				$ret = new Mongo( $mongodb_i['host'] );
				$ret = $ret->$dbname; // select a database
			}
			catch(Exception $e)
			{
				die('MongoDBFactory: '.$e->getMessage());
			}
			self::$dbh = $ret;
			return self::$dbh;
		}
		return self::$dbh;
	}
}
