<?php
/** 
 * Thin PHP Framework (TPF) 2011 http://thinphp.com
 *
 * Licensed under TPF License at http://bit.ly/TPFLicense
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2011, Thin PHP Framework Team
 * @link          http://thinphp.com
 * @package       app.model.base.driver
 * @license       TPF License http://bit.ly/TPFLicense
 */
defined('BASE') or exit('Direct script access is not allowed!');

class DBPdoMysql
{
	private $_dbh;
	
	public function __construct($dbinfo)
	{
		try {
			$connStr = 'mysql:host='.$dbinfo['host'].';dbname='.$dbinfo['dbname'];
			$this->_dbh = new PDO($connStr,
							$dbinfo['username'], $dbinfo['password'],
							array(PDO::ATTR_PERSISTENT => true)); // to reuse PDO conn
			$this->_dbh->exec("SET CHARACTER SET utf8"); // must be set for UTF8			
		}
		catch(PDOException $e)
		{
			die('DBPdoMysql: '.$e->getMessage());
		}		
	}
	
	public function getDBHandler() {
		return $this->_dbh;
	}
}
