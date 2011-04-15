<?php
defined('BASE') or exit('Direct script access is not allowed!');
require_once BASE.'/app/model/base/BaseDAO.php';

class CommentDAO extends BaseDAO
{
	public function __construct()
	{
		parent::__construct('comment');		
	}
	
	public function getByPostId($postId)
	{
		if ($this->dbh == null) return;
		$sql = 'SELECT * FROM '.$this->table.' WHERE postId = '.$postId;
		$queryRes = $this->dbh->query($sql);		
		if ($queryRes != null) {
			return $queryRes->fetchAll();
		}
		return null;
	}
}
?>
