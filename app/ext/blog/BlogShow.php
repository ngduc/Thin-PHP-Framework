<?php
defined('BASE') or exit('Direct script access is not allowed!');
require_once "BlogComment.php";

class BlogShow extends BaseController
{
	public function view()
	{
		$postId = $this->params[0];
		$dao = DAO::getDAO('PostDAO');
		
		$post = $dao->getById($postId);
		$postContent = html_entity_decode($post['content']);
		$postComments = BaseController::callController(BASEEXT.'/blog', 'BlogComment', array($postId));
		
		$v = $this->smarty;
		$v->setTemplateDir(BASEEXT.'/blog/view');
		$v->assign('post', $post);
		$v->assign('postContent', $postContent);
		$v->assign('postComments', $postComments);
        $this->display($v, 'blog_show.html');
	}
}
