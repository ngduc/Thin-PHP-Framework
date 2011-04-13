<?php
defined('BASE') or exit('Direct script access is not allowed!');
require_once BASE.'/app/model/Post.php';
require_once BASE.'/app/model/base/DAOs.php';

class BlogList
{
	public static function getPosts()
	{
		$dao = DAOs::getDAO('PostDAO');
		$posts = $dao->getAll();
		        
		return $posts;
	}
}
?>