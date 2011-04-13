<?php
defined('BASE') or exit('Direct script access is not allowed!');
require_once "BlogList.php";
require_once "BlogShow.php";
require_once "BlogEdit.php";

require_once BASE.'/app/model/Post.php';
require_once BASE.'/app/model/base/DAOs.php';

class Blog extends BaseController
{
	public function processPOST()
	{
		parent::processPOST();
		BlogEdit::update();
		header('Location: '.$_SERVER['HTTP_REFERER']);		
	}
	
	private function processAction($dao, $v)
	{
		if ( !isset($this->params[0])) $action = 'list'; // default action
		$action = trim($this->params[0]);
		
		if ($action == 'show' || $action == 'edit')
		{
			$id = trim(sanitize_str($this->params[1]));			
			if ($action == 'show') {		
				$html = BlogShow::show($id);
			}
			else {
				$html = BlogEdit::show($id);
			}			
			$v->assign('inc_content', 'blank.html');
			$v->assign('content', $html);		
		}
		else {
			if ($action == 'remove')
			{
				// ex: requesting: /blog/p/delete/2
				$id = trim(sanitize_str($this->params[1]));
				$dao->removeById($id);
			}
			else if ($action == 'add')
			{
				$randNum = mt_rand(0, 99999);
				$dbNow = date( 'Y-m-d H:i:s' );			
				$newPost = new Post(
								array('title' => 'Blog entry '.$randNum,
									'description' => 'description '.$randNum,
									'content' => 'content '.$randNum,
									'createTime' => $dbNow)
							);			
				// #TODO: implement UserDao.create($newUser) instead.			
				$dao->execute("INSERT INTO post(title, description, content, createTime)
							VALUES(:title, :description, :content, :createTime)", $newPost->getFields());
			}
			$posts = $dao->getAll();
			
			$v->assign('inc_content', BASEEXT.'/blog/BlogList_inc.html');
	        $v->assign('posts', $posts);
	        $v->assign('totalPosts', $dao->countAll());
	        $v->assign('content', '');
		}
		return $html;
	}
	
	public function view()
	{
		if ($this->isPosting()) return $this->processPOST();

		$dao = DAOs::getDAO('PostDAO');

		$v = $this->smarty;
        $v->assign('title', t('home_page_title'));

        $this->processAction($dao, $v);

        $this->display($v, v('index.html'));
	}
}
?>