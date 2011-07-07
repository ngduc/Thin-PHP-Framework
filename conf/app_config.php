<?php
/** 
 * Thin PHP Framework (TPF) 2011 http://thinphp.com
 *
 * Licensed under TPF License at http://bit.ly/TPFLicense
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2011, Thin PHP Framework Team
 * @link          http://thinphp.com
 * @package       app.conf
 * @license       TPF License http://bit.ly/TPFLicense
 */

	// The following parameters must be changed to your settings!

	// App Info
	$app_i = array(
		'default_view'	=> 'en_default',			// default view directory
		'default_controller' => '',					// fallback (catch-all) controller if URI parsing failed
		'flood_limit'	=> 0,						// e.g. 0.5 second - require 'cache' to work
		'cache'		=> CC_NOCACHE,					// cache method (more: constants.php)
		'timezone'	=> 'America/Los_Angeles',		// more: http://j.mp/kicmqy
		'md5salt'	=> 'MyR@nd0mStr1ng',			// any random string (used for salt)
		'demo_mode'	=> 1
	);
	
	// Database Info - change here, then setup: run http://yourwebapp/tools/setup-db/index.php
	$db_i = array(
		'env' => 'env_test',					// set which Environment (env) you want to run.
		'env_test' => array(
			'dbdriver' => DB_PDO_SQLITE,
			'host'     => '',
			'username' => '',
			'password' => '',
			'dbname'   => '/app/appdata/thinphp.db3'
		),
		'env_production' => array(
			'dbdriver' => DB_PDO_MYSQL,
			'host'     => 'localhost',
			'username' => 'mysqluser',
			'password' => 'mysqlpassword',
			'dbname'   => 'thinphp'
		)
	);
	
	// Memcache Info (set if using CC_MEMCACHE in $app_i['cache'])
	$memcache_i = array(
		'server'	=> 'localhost',
		'port'		=> '11211'
	);
	
	// MongoDB settings
    $mongodb_i = array(
        'host'      => 'localhost',
        'dbname'    => 'thinphp'
    );
	
	// Log Info
	$log_i = array(
		'enabled'		=> 1,
		'log_level'		=> LL_ERROR | LL_FATAL,
		'log_to'		=> LG_FILE,
		'log_file'		=> '/app/appdata/log/main.txt',
		'log_max_file_size'	=> 512000,	// = 500 KB = 500*1024 bytes
		'log_max_backup_index' => 5,	// max number of log files to keep
		'log_pattern'	=> '{time} {name} [{type_padleft}] - {msg}',
		'log_time_format'	=> 'Y-m-d H:i:s.ms'
	);
