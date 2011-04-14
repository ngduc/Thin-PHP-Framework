<?php
defined('BASE') or exit('Direct script access is not allowed!');

class BlogShow
{
	public static function show($id)
	{
		$dao = DAOs::getDAO('PostDAO');
		$post = $dao->getById($id);
		
		$html = file_get_contents_with_vars(BASEEXT.'/blog/BlogShow_inc.html', array(
							'{$postTitle}' => $post['title'],
							'{$postContent}' => html_entity_decode($post['content']) ));

		$html .= '<br/>&nbsp;<br/><a href="javascript:history.go(-1)">Go Back</a>';
		return $html;
	}
}
?>