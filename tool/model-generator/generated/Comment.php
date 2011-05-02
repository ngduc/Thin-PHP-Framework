<?php
defined('BASE') or exit('No direct script access allowed!');
require_once BASE.'/app/model/base/BaseBO.php';

/**
 * Auto generated Model Class represents table 'comment' 
 * @author: Thin PHP Framework
 * @date: 2011-05-01 21:59
 */
class Comment extends BaseBO
{
	private $fields;
	private $commentId;
	private $type;
	private $itemId;
	private $replyToId;
	private $weight;
	private $title;
	private $content;
	private $authorName;
	private $authorEmail;
	private $authorURL;
	private $authorIP;
	private $points;
	private $flagApproved;
	private $updateTime;
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
		$this->type = $fields['type'];
		$this->itemId = $fields['itemId'];
		$this->replyToId = $fields['replyToId'];
		$this->weight = $fields['weight'];
		$this->title = $fields['title'];
		$this->content = $fields['content'];
		$this->authorName = $fields['authorName'];
		$this->authorEmail = $fields['authorEmail'];
		$this->authorURL = $fields['authorURL'];
		$this->authorIP = $fields['authorIP'];
		$this->points = $fields['points'];
		$this->flagApproved = $fields['flagApproved'];
		$this->updateTime = $fields['updateTime'];
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

	public function getType() {
		return $this->type;
	}
	public function setType($type) {
		$this->type = $type;
	}

	public function getItemId() {
		return $this->itemId;
	}
	public function setItemId($itemId) {
		$this->itemId = $itemId;
	}

	public function getReplyToId() {
		return $this->replyToId;
	}
	public function setReplyToId($replyToId) {
		$this->replyToId = $replyToId;
	}

	public function getWeight() {
		return $this->weight;
	}
	public function setWeight($weight) {
		$this->weight = $weight;
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

	public function getPoints() {
		return $this->points;
	}
	public function setPoints($points) {
		$this->points = $points;
	}

	public function getFlagApproved() {
		return $this->flagApproved;
	}
	public function setFlagApproved($flagApproved) {
		$this->flagApproved = $flagApproved;
	}

	public function getUpdateTime() {
		return $this->updateTime;
	}
	public function setUpdateTime($updateTime) {
		$this->updateTime = $updateTime;
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
		return ''.':'.$this->commentId.':'.$this->type.':'.$this->itemId.':'.$this->replyToId.':'.$this->weight.':'.$this->title.':'.$this->content.':'.$this->authorName.':'.$this->authorEmail.':'.$this->authorURL.':'.$this->authorIP.':'.$this->points.':'.$this->flagApproved.':'.$this->updateTime.':'.$this->createTime;
	}
}
