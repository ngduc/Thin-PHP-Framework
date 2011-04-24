<?php
/** 
 * Thin PHP Framework (TPF) 2011 http://thinphp.com
 *
 * Licensed under TPF License at http://bit.ly/TPFLicense
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2011, Thin PHP Framework Team
 * @link          http://thinphp.com
 * @package       app.cache.base
 * @license       TPF License http://bit.ly/TPFLicense
 */
defined('BASE') or exit('No direct script access allowed!');
require_once 'ICache.php';

abstract class BaseCache implements ICache
{	
	private $_prefix;
	
	/**
	 * Constructor
	 */
	public function __construct($prefix)
	{
		$this->_prefix = $prefix;
	}
	
	private function getId_md5($id)
	{
		// append 'prefix' to $id
		return md5($this->_prefix.$id);
	}
	
	// ================== MUST BE IMPLEMENTED IN EXTENDING CLASSES ================== //
	
	abstract protected function getEntry($id);

	abstract protected function setEntry($id, $value, $lifeinsecs=0);

	abstract protected function delEntry($id);
	
	// ================== PUBLIC FUNCTIONS ================== //
	
	public function get($id)
	{
		if (($val = $this->getEntry($this->getId_md5($id))) !== false)
		{
			return $val;
		}
		return false;
	}
	
	public function set($id, $value, $lifeinsecs=0)
	{
		return $this->setEntry($this->getId_md5($id), $value, $lifeinsecs);
	}
	
	public function del($id)
	{
		return delEntry($id);
	}
}
