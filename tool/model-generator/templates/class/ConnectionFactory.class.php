<?php
/*
 * Class return connection to database
 *
 * @author: http://phpdao.com
 * @date: 27.11.2007
 */
require_once dirname(__FILE__)."/../../../../conf/app_config.php";

class ConnectionFactory
{
	static public function getConnection()
	{
		global $db_i;
		$dbenv = $db_i[$db_i['env']];

		$host = $dbenv['host'];
		$user = $dbenv['username'];
		$password = $dbenv['password'];
		$database = $dbenv['dbname'];
	
		$conn = mysql_connect($host, $user, $password);
		mysql_select_db($database);		
		if(!$conn){
			echo 'ERROR: Could not connect to Database! Please check your config file.';
			throw new Exception('ERROR: Could not connect to Database. Please check your config.');
		}
		return $conn;
	}

	static public function close($connection){
		mysql_close($connection);
	}
}
