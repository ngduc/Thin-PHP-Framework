<?php
defined('BASE') or exit('Direct script access is not allowed!');

class BlogEdit extends BaseController
{
	public function processPOST()
	{		
		parent::processPOST();

		copy_fields($_POST, $fv, F_ENCODE, 'postId', 'title', 'content');
		$dao = DAOs::getDAO('PostDAO');
		$dao->update("title = '$fv[title]', content = '$fv[content]' WHERE postId = $fv[postId]");
	}

	public function view()
	{
		if ($this->isPosting()) return $this->processPOST();
		
		$postId = $this->params[0];
		$dao = DAOs::getDAO('PostDAO');
		$post = $dao->getById($postId);
		$post['content'] = html_entity_decode($post['content']);

		$v = $this->smarty;
		$v->setTemplateDir(BASEEXT.'/blog/view');
		$v->assign('post', $post);		
        $this->display($v, 'blog_edit_inc.html');
	}
}
?>