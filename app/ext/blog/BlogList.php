<?php
defined('BASE') or exit('Direct script access is not allowed!');
require_once BASE.'/app/model/Post.php';
require_once BASE . '/app/model/base/DAO.php';

class BlogList extends BaseController
{
	public function view()
	{
		$dao = DAO::getDAO('PostDAO');
		$posts = $dao->getAll();

		for ($i = 0, $cnt = count($posts); $i < $cnt; $i++) {
			$content = html_entity_decode($posts[$i]['content']);
			$content = str_replace("\n", '<br/>', $content);
			$posts[$i]['content'] = $content;
			$posts[$i]['seoTitle'] = seoTitle($posts[$i]['title']);
		}
		
		$v = $this->smarty;
		$v->setTemplateDir(BASEEXT.'/blog/view');
		$v->assign('posts', $posts);
        $this->display($v, 'blog_list.html');
	}
}
