<?php
/**
 * Thin PHP Framework (TPF) 2011-2012 http://thinphp.com
 * @package       app.model.base.driver
 * @license       TPF License http://bit.ly/TPFLicense
 */
defined('BASE') or exit('Direct script access is not allowed!');

class DBPdoSqlite
{
	private $_dbh;
	
	public function __construct($dbinfo)
	{
		try {
			$dbpath = BASE.$dbinfo['dbname'];			
			$connStr = 'sqlite:'.$dbpath;
			$this->_dbh = new PDO($connStr,
							$dbinfo['username'], $dbinfo['password'],
							array(PDO::ATTR_PERSISTENT => true)); // to reuse PDO conn
			$this->_dbh->exec("SET CHARACTER SET utf8"); // must be set for UTF8			
		}
		catch(PDOException $e)
		{
			die('DBPdoSqlite: '.$e->getMessage());
		}
	}
	
	public function getDBHandler() {
		return $this->_dbh;
	}
}
