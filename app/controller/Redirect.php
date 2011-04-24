<?php

class Redirect extends BaseController
{
	private $log;
	public function __construct()
	{
		$this->log = Logger::getFileLogger(__CLASS__, '/app/appdata/log/redirect.txt');
	}

	public function view()
	{
		if ( !isset($this->params[0])) die('Invalid parameters!');
		$toURL = $this->params[0];
		
		$this->log->info($toURL);
		header("Location: $toURL");
	}
}

