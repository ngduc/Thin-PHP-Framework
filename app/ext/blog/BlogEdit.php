<?php
defined('BASE') or exit('Direct script access is not allowed!');
require_once BASEEXT.'/wiki2html/Wiki2html.php';

class BlogEdit extends BaseController
{
	public function processPOST()
	{		
		parent::processPOST();

		copyItems($_POST, $fv, 'postId', 'title', 'content');
		$dao = DAO::getDAO('PostDAO');
		$dao->update("title = '$fv[title]', content = '$fv[content]' WHERE postId = $fv[postId]");
	}

	public function view()
	{
		if ($this->isPosting()) return $this->processPOST();
		
		$postId = $this->params[0];
		$dao = DAO::getDAO('PostDAO');
		$post = $dao->getById($postId);
		
		$postContent = $post['content'];
		$postContent = html_entity_decode($postContent);
        $postContent = Wiki2html::process($postContent);

		$v = $this->smarty;
		$v->setTemplateDir(BASEEXT.'/blog/view');
		$v->assign('post', $post);
		$v->assign('postContent', $postContent);
        $this->display($v, 'blog_edit.html');
	}
}
