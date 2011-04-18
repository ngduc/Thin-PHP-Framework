<?php
defined('BASE') or exit('Direct script access is not allowed!');
require_once BASE.'/app/model/base/BaseDAO.php';

class CommentDAO extends BaseDAO
{
	public function __construct()
	{
		parent::__construct('comment');
	}
	
	public function getComments($type, $itemId)
	{
		if ($this->dbh == null) return;
		$sql = 'SELECT * FROM '.$this->table.' WHERE type='.$type.' AND itemId='.$itemId.' ORDER BY weight';
		$queryRes = $this->dbh->query($sql);
		if ($queryRes != null) {
			return $queryRes->fetchAll();
		}
		return null;
	}
	
	function getLastComment($parentCommentId)
	{
		if ($this->dbh == null) return;
		$sql = 'SELECT * FROM '.$this->table.' WHERE replyToId = '.$parentCommentId.' AND weight <>0 ORDER BY weight DESC LIMIT 1';
		$queryRes = $this->dbh->query($sql);		
		if ($queryRes != null) {
			$res = $queryRes->fetchAll();
			return $res[0]; // 1 row
		}
		return null;
	}
}
?>
