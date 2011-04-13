<?php
defined('BASE') or exit('Direct script access is not allowed!');

class BlogEdit
{
	public static function update($fv)
	{
		copy_fields($_POST, $fv, F_ENCODE, 'postId', 'title', 'content');
		$dao = DAOs::getDAO('PostDAO');
		$dao->update("title = '$fv[title]', content = '$fv[content]' WHERE postId = $fv[postId]");
	}
	
	public static function show($id)
	{
		$dao = DAOs::getDAO('PostDAO');
		$post = $dao->getById($id);
		
		$html = file_get_contents_with_vars(BASEEXT.'/blog/BlogEdit_inc.html', $post);
		return $html;
	}
}
?>