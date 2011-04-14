<?php
defined('BASE') or exit('Direct script access is not allowed!');
require_once BASE.'/app/model/Post.php';
require_once BASE.'/app/model/base/DAOs.php';

class BlogList
{
	public static function show()
	{
		$dao = DAOs::getDAO('PostDAO');
		$posts = $dao->getAll();

		foreach ($posts as $post)
	    {
	    	$p = new Post($post);
			$html .= '<h3>'.$p->getTitle().'</h3>'.$p->getContent().'<p/>';
	    }

		$html .= '<br/>&nbsp;<br/><a href="/blog-admin">Blog Admin</a>';
		return $html;
	}
}
?>