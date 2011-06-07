<?php
defined('BASE') or exit('Direct script access is not allowed!');
require_once BASE.'/app/model/Comment.php';

class BlogComment extends BaseController
{
	public function validate($retType)
	{
		parent::validate($retType);
		copyArray($_POST, $fv, 'name', 'email', 'content');

		if (trim($fv['name']) == '') {
			$rets[] = array('msg' => 'Please enter your name!', 'field' => 'name');
		}
		if (filter_var($fv['email'], FILTER_VALIDATE_EMAIL) === FALSE) {
    		$rets[] = array('msg' => 'Invalid email!', 'field' => 'email');
        }
        if (trim($fv['content']) == '') {
			$rets[] = array('msg' => 'Please enter content!', 'field' => 'content');
		}
		if (isset($rets)) {
	        if (isset($retType) && $retType == RT_JSON) {
	        	return outputJson($rets);
	        } else {
	        	return $rets;
	        }
	    }
	}
	
	public function processPost()
	{		
		parent::processPost();

		copyArray($_POST, $fv, 'itemId', 'replyToId', 'name', 'email', 'content', 'parentCommentWeight');
		$dao = DAO::getDAO('CommentDAO');

		// #TODO: validate here...
		if (trim($fv['content']) != '')
		{
			$parentW = $fv['parentCommentWeight'];
			
			$dbNow = date( 'Y-m-d H:i:s' );
			$newComment = new Comment(
								array('itemId' => $fv['itemId'],
										'replyToId' => $fv['replyToId'],
										'authorName' => $fv['name'],
										'authorEmail' => $fv['email'],
										'content' => $fv['content'],
										'weight' => '0',
										'createTime' => $dbNow)
								);
			$dao->execute("INSERT INTO comment(type, itemId, replyToId, weight, authorName, authorEmail, content, createTime)
						VALUES(1, :itemId, :replyToId, :weight, :authorName, :authorEmail, :content, :createTime)", $newComment->getFields());
			
			// update new Comment's Weight
			$weight = 0;			
			$newId = $dao->getDbHandler()->lastInsertId();			
			if ($parentW == '') {
				$weight = $newId;
			}
			else {
				if (strpos($parentW.'', '.') === false) {
					$weight = (double)($parentW.'.01');
				} else {
					$r = $dao->getLastComment($fv['replyToId']);
					if ($r == null) {	// no child comment
						$weight = $parentW.'01';
					}
					else {
						$lw = $r['weight'];		// last comment's weight, ex: 2.09				
						$floor_lw = floor($lw);	// = 2
						$sRemainder = fmod($lw, $floor_lw).''; // 2.22 % 2 = 0.09							
						$sRemainder = str_replace('0.', '1', $sRemainder); // = '109'
						$weight = $sRemainder + 1;	// = 110
						$sRemainderNew = substr($weight.'',	1); // '10'
						$weight = $floor_lw.'.'.$sRemainderNew;	// = 2.10
					}								
				}
			}			
			$dao->update('weight = ? WHERE commentId = ?', array($weight, $newId));
		}
	}
	
	public function view()
	{
		if ($this->isValidating()) return $this->validate(RT_JSON);
		if ($this->isPosting()) return $this->processPost();
		
		$itemId = $this->params[0];
		$dao = DAO::getDAO('CommentDAO');
		$comments = $dao->getComments(1, $itemId);
		
		// prepare Comments for the View
		for ($i = 0, $cnt = count($comments); $i < $cnt; $i++)
		{
			$cmt = $comments[$i];
			$stEmail = trim($cmt['authorEmail']);
			if ($stEmail != '') {
				$comments[$i]['gravatarImg'] = '<img src="http://www.gravatar.com/avatar/'.md5($stEmail).'?d=mm&s=64">';
			}
			$content = html_entity_decode($cmt['content']);
			$content = str_replace("\n", '<br/>', $content);
			$comments[$i]['content'] = $content;
			
			$sWeight = $cmt['weight'].''; // calculate indent (for left-margin) from weight
			if (strpos($sWeight, '.') === false) {
				$comments[$i]['indent'] = 0;
			} else {
				$sWeight = substr($sWeight, strpos($sWeight, '.')+1);				
				$comments[$i]['indent'] = strlen($sWeight)/2;
			}
		}

		$v = $this->smarty;
		$v->setTemplateDir(BASEEXT.'/blog/view');

		$v->assign('commentTotal', count($comments));
		$v->assign('comments', $comments);
		$v->assign('itemId', $itemId);
        $this->display($v, 'blog_comment.html');
	}
}
