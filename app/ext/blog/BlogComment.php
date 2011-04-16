<?php
defined('BASE') or exit('Direct script access is not allowed!');
require_once BASE.'/app/model/Comment.php';

class BlogComment extends BaseController
{
	public function processPOST()
	{
		parent::processPOST();

		copy_fields($_POST, $fv, F_ENCODE, 'postId', 'name', 'email', 'content');
		$dao = DAOs::getDAO('CommentDAO');

		// #TODO: validate here...
		if (trim($fv['content']) != '')
		{
			$dbNow = date( 'Y-m-d H:i:s' );
			$newComment = new Comment(
								array('postId' => $fv['postId'],
										'authorName' => $fv['name'],
										'authorEmail' => $fv['email'],
										'content' => $fv['content'],
										'createTime' => $dbNow)
								);
			$dao->execute("INSERT INTO comment(postId, authorName, authorEmail, content, createTime)
						VALUES(:postId, :authorName, :authorEmail, :content, :createTime)", $newComment->getFields());			
		}
	}
	
	public function view()
	{		
		if ($this->isPosting()) return $this->processPOST();
		
		$postId = $this->params[0];
		$dao = DAOs::getDAO('CommentDAO');
		
		$comments = $dao->getByPostId($postId);
		for ($i = 0, $cnt = count($comments); $i < $cnt; $i++) {
			$cmt = $comments[$i];
			$stEmail = trim($cmt['authorEmail']);
			if ($stEmail != '') {
				$comments[$i]['gravatarImg'] = '<img src="http://www.gravatar.com/avatar/'.md5($stEmail).'?d=mm&s=64">';
			}
			$content = html_entity_decode($cmt['content']);
			$content = str_replace("\n", '<br/>', $content);
			$comments[$i]['content'] = $content;
		}

		$v = $this->smarty;
		$v->setTemplateDir(BASEEXT.'/blog/view');

		$v->assign('commentTotal', count($comments));
		$v->assign('comments', $comments);
		$v->assign('postId', $postId);
        $this->display($v, 'blog_comment_inc.html');
	}
}
?>