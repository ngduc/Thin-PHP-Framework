<?php
defined('BASE') or exit('No direct script access allowed!');
require_once BASE.'/app/model/base/BaseBO.php';

/**
 * Auto generated Model Class represents table 'comment' 
 * @author: Thin PHP Framework
 * @date: 2011-04-14 03:29
 */
class Comment extends BaseBO
{
	private $fields;
	private $commentId;
	private $postId;
	private $title;
	private $content;
	private $authorName;
	private $authorEmail;
	private $authorURL;
	private $authorIP;
	private $point;
	private $isApproved;
	private $createTime;


	/**
	 * Default constructor
	 * @param value some value
	 */
	function __construct()
	{
		$args = func_get_args();
		if ( func_num_args() == 1 ) {
			$this->init( $args[0] );
		}
	}

	/**
	 * Initialize the business object with data read from the DB.
	 * @param row array containing one read record.
	 */
	private function init($fields)
	{
		$this->fields = $fields;
		$this->commentId = $fields['commentId'];
		$this->postId = $fields['postId'];
		$this->title = $fields['title'];
		$this->content = $fields['content'];
		$this->authorName = $fields['authorName'];
		$this->authorEmail = $fields['authorEmail'];
		$this->authorURL = $fields['authorURL'];
		$this->authorIP = $fields['authorIP'];
		$this->point = $fields['point'];
		$this->isApproved = $fields['isApproved'];
		$this->createTime = $fields['createTime'];
	
	}

	public function getFields() {
		return $this->fields;
	}

	
	public function getCommentId() {
		return $this->commentId;
	}
	public function setCommentId($commentId) {
		$this->commentId = $commentId;
	}

	public function getPostId() {
		return $this->postId;
	}
	public function setPostId($postId) {
		$this->postId = $postId;
	}

	public function getTitle() {
		return $this->title;
	}
	public function setTitle($title) {
		$this->title = $title;
	}

	public function getContent() {
		return $this->content;
	}
	public function setContent($content) {
		$this->content = $content;
	}

	public function getAuthorName() {
		return $this->authorName;
	}
	public function setAuthorName($authorName) {
		$this->authorName = $authorName;
	}

	public function getAuthorEmail() {
		return $this->authorEmail;
	}
	public function setAuthorEmail($authorEmail) {
		$this->authorEmail = $authorEmail;
	}

	public function getAuthorURL() {
		return $this->authorURL;
	}
	public function setAuthorURL($authorURL) {
		$this->authorURL = $authorURL;
	}

	public function getAuthorIP() {
		return $this->authorIP;
	}
	public function setAuthorIP($authorIP) {
		$this->authorIP = $authorIP;
	}

	public function getPoint() {
		return $this->point;
	}
	public function setPoint($point) {
		$this->point = $point;
	}

	public function getIsApproved() {
		return $this->isApproved;
	}
	public function setIsApproved($isApproved) {
		$this->isApproved = $isApproved;
	}

	public function getCreateTime() {
		return $this->createTime;
	}
	public function setCreateTime($createTime) {
		$this->createTime = $createTime;
	}



	/**
	 * Return value of this object in a short string for debug.
	 */
	public function toStr()
	{
		return ''.':'.$this->commentId.':'.$this->postId.':'.$this->title.':'.$this->content.':'.$this->authorName.':'.$this->authorEmail.':'.$this->authorURL.':'.$this->authorIP.':'.$this->point.':'.$this->isApproved.':'.$this->createTime;
	}
}
?>