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
			$listHTML .= '<h3>'.$p->getTitle().'</h3>'.html_entity_decode($p->getContent()).'<p/>';
			$listHTML .= '	<span id="commentTime">'.$p->getCreateTime().'</span><br/>';
			$listHTML .= '<a style="font-size: 0.9em" href="/blog/p/show/'.$p->getPostId().'">more...</a>';
	    }
	    
	    $html = file_get_contents_with_vars(BASEEXT.'/blog/view/BlogList_inc.html', array(
							'{$listHTML}' => $listHTML ));
		return $html;
	}
}
?>