<?php
	define('BASE', dirname(__FILE__).'/../..');
	require_once BASE.'/app/includes.php';
	require_once BASE.'/app/model/base/DBFactory.php';
	
	$dbenv = $db_i[$db_i['env']];

	// ------ DB ------ //
	function connect_DB()
	{		
		return DBFactory::getDBHandler();
	}

	// get the left part of the string from $fromst. ex: left_from("myemail@example.com", "@");
    function left_from($st, $fromst)
    {
    	$p = strpos ($st, $fromst);
		if ($p === false) return $st; // not found $fromst
		return substr($st, 0, $p);
    }

