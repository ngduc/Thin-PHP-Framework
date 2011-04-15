<?php
defined('BASE') or exit('Direct script access is not allowed!');
require_once BASE.'/app/model/Comment.php';

class BlogComment
{
	public static function update()
	{		
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
	
	public static function show($postId)
	{
		$dao = DAOs::getDAO('CommentDAO');
		$comments = $dao->getByPostId($postId);

		$html = '<p/><span id="commentTotal">'.count($comments).' User Comment(s):</span>';
		foreach ($comments as $comment)
	    {
	    	$c = new Comment($comment);
	    	$content = html_entity_decode($c->getContent());
	    	$content = str_replace("\n", '<br/>', $content);
	    	$gravatar = '';
	    	if ($c->getAuthorEmail() != '') $gravatar = '<img src="http://www.gravatar.com/avatar/'.md5(trim($c->getAuthorEmail())).'">';
	    	
	    	$html .= '<div id="commentBox">';
	    	$html .= '	<div id="commentAvatar">'.$gravatar.'</div>';
			$html .= '	<h4>'.$c->getAuthorName().'</h4>'.$content.'<p/>';
			$html .= '	<span id="commentTime">'.$c->getCreateTime().'</span>';
			$html .= '</div>';
	    }
		// show Comment Form
		$html .= file_get_contents_with_vars(BASEEXT.'/blog/view/BlogComment_inc.html', array(
								'{$postId}' => $postId
							));
		return $html;
	}
}
?>