<?php
/**
 * Thin PHP Framework (TPF) 2011-2012 http://thinphp.com
 * @package       app.cache.base
 * @license       TPF License http://bit.ly/TPFLicense
 */
defined('BASE') or exit('No direct script access allowed!');

interface ICache
{
	public function get($id);
	
	public function set($id, $value, $lifeinsecs=0);
	
	public function del($id);
}
