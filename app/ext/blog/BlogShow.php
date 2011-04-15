<?php
defined('BASE') or exit('Direct script access is not allowed!');
require_once "BlogComment.php";

class BlogShow
{
	public static function show($postId)
	{
		$dao = DAOs::getDAO('PostDAO');
		$post = $dao->getById($postId);
		
		$html = file_get_contents_with_vars(BASEEXT.'/blog/view/BlogShow_inc.html', array(
							'{$postTitle}' => $post['title'],
							'{$postContent}' => html_entity_decode($post['content']),
							'{$postComments}' => BlogComment::show($postId)
						));
		return $html;
	}
}
?>