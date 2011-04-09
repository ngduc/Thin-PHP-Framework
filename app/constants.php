<?php
	defined('BASE') or exit('Direct script access is not allowed!');	

	// DB Drivers
	define('DB_PDO_SQLITE', 1);
	define('DB_PDO_MYSQL', 2);

	// Cache Methods
	define('CC_NOCACHE', 0);
	define('CC_APC', 1);
	define('CC_MEMCACHE', 2);
	
	// Log Levels flags
	define('LL_NOLOG', 0);
	define('LL_ALL', 63);
	define('LL_INFO', 2);
	define('LL_DEBUG', 4);
	define('LL_WARN', 8);
	define('LL_ERROR', 16);
	define('LL_FATAL', 32);
	
	// Log to
	define('LG_FILE', 1);
	
	// for Controller's validate() function
	define('RT_NONE', 0);
	define('RT_JSON', 1);
?>
