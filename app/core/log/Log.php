<?php
/** 
 * Thin PHP Framework (TPF) 2011 http://thinphp.com
 *
 * Licensed under TPF License at http://bit.ly/TPFLicense
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2011, Thin PHP Framework Team
 * @link          http://thinphp.com
 * @package       app.core.log
 * @license       TPF License http://bit.ly/TPFLicense
 */
defined('BASE') or exit('No direct script access allowed!');

class Log
{
	private $_filePath;
	private $_name;
	
	private $_fh;

	/**
	 * Constructor
	 */
	public function __construct($name, $filePath)
	{
		if ( !Logger::$settings['enabled']) return;
		$this->_name = $name;
		$this->_filePath = $filePath;		
				
		if (Logger::$settings['log_to'] == LG_FILE) {
			$this->openLogFile();
		}
	}
	
	function __destruct() {
		if ($this->_fh != null) fclose($this->_fh); // Close when php script ends
	}

	private function openLogFile()
	{	
		$fpath = BASE.$this->_filePath;
		
		if (file_exists($fpath) && filesize($fpath) > Logger::$settings['log_max_file_size'])
		{
			// log file exceeded max size => roll log filename
			$maxidx = Logger::$settings['log_max_backup_index'];
			if ($maxidx > 0) // roll log files: log.ext is most recent, then log.ext.1...
			{
				$cnt = 1;
				while (file_exists($fpath.'.'.$cnt)) $cnt++;
				if ($cnt > $maxidx) @unlink($fpath.'.'.$maxidx); // delete the oldest file					
				for ($i = $cnt-1; $i >= 1; $i--) {
					rename($fpath.'.'.$i, $fpath.'.'.($i+1)); // shift the rest to older index
				}
				rename($fpath, $fpath.'.1');
			} else {
				@unlink($fpath); // no roll
			}
		}
		//$this->_fh = fopen($fpath, 'a') or exit("Can't open log file!"); // only fopen file on the 1st writeLogFile().
	}
	
  	private function writeLogFile($type, $msg)
  	{
        if ($this->_fh == null) $this->_fh = fopen(BASE.$this->_filePath, 'a'); // only fopen file on the 1st writeLogFile().

  		// #TODO: optimize this
  		$df = Logger::$settings['log_time_format'];  		
  		if (strpos($df, 'ms') !== false) {
  			$addMilliSecs = 1;
  			$df2 = str_replace('ms', '~~', $df);
  			$now = date($df2);  			
  			$mt = microtime(); // ex: 0.1234567 xxxxxxx
  			$now = str_replace('~~', $mt[2].$mt[3].$mt[4], $now); // insert milliseconds
  		}
  		else {
			$now = date($df);
		}
		$s = Logger::$settings['log_pattern'];
		$s = str_replace('{time}', $now, $s);
		$s = str_replace('{name}', $this->_name, $s);
		if (strpos($s, '{type_padright}') !== false) {
			$type = str_pad($type, 5, ' ');
			$s = str_replace('{type_padright}', $type, $s);
		}
		else if (strpos($s, '{type_padleft}') !== false) {
			$type = str_pad($type, 5, ' ', STR_PAD_LEFT);
			$s = str_replace('{type_padleft}', $type, $s);
		}
		$s = str_replace('{type}', $type, $s);
		$s = str_replace('{msg}', $msg, $s);
		fwrite($this->_fh, $s."\n");
  	}

	// ================== PUBLIC FUNCTIONS ================== //
	
	public function msg($msg)
	{
		// force log message no matter what Log Level is
		if ( !Logger::$settings['enabled']) return;
		$this->writeLogFile('', $msg);
	}
			
	public function info($msg)
	{
		if ( !Logger::$settings['enabled']) return;
		if (Logger::$settings['log_level'] & LL_INFO) {
			$this->writeLogFile('INFO', $msg);
		}
	}
	
	public function debug($msg)
	{
		if ( !Logger::$settings['enabled']) return;
		if (Logger::$settings['log_level'] & LL_DEBUG) {
			$this->writeLogFile('DEBUG', $msg);
		}
	}
	
	public function warn($msg)
	{
		if ( !Logger::$settings['enabled']) return;
		if (Logger::$settings['log_level'] & LL_WARN) {
			$this->writeLogFile('WARN', $msg);
		}
	}
	
	public function error($msg)
	{
		if ( !Logger::$settings['enabled']) return;
		if (Logger::$settings['log_level'] & LL_ERROR) {
			$this->writeLogFile('ERROR', $msg);
		}
	}
	
	public function fatal($msg)
	{
		if ( !Logger::$settings['enabled']) return;
		if (Logger::$settings['log_level'] & LL_FATAL) {
			$this->writeLogFile('FATAL', $msg);
		}
	}
}
