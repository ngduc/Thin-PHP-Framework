<?php
defined('BASE') or exit('Direct script access is not allowed!');
require_once BASE.'/app/model/base/BaseDAO.php';

class PostDAO extends BaseDAO
{
	public function __construct()
	{
		parent::__construct('post');				
	}	
}
?>
