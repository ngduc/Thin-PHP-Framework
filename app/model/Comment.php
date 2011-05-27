<?php
defined('BASE') or exit('No direct script access allowed!');
require_once BASE.'/app/model/base/BaseBO.php';

/**
 * Auto generated Model Class represents table 'comment' 
 * @author: Thin PHP Framework
 * @date: 2011-05-27 12:47
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
		if (isset($fields['commentId'])) $this->commentId = $fields['commentId'];
		if (isset($fields['type'])) $this->type = $fields['type'];
		if (isset($fields['itemId'])) $this->itemId = $fields['itemId'];
		if (isset($fields['replyToId'])) $this->replyToId = $fields['replyToId'];
		if (isset($fields['weight'])) $this->weight = $fields['weight'];
		if (isset($fields['title'])) $this->title = $fields['title'];
		if (isset($fields['content'])) $this->content = $fields['content'];
		if (isset($fields['authorName'])) $this->authorName = $fields['authorName'];
		if (isset($fields['authorEmail'])) $this->authorEmail = $fields['authorEmail'];
		if (isset($fields['authorURL'])) $this->authorURL = $fields['authorURL'];
		if (isset($fields['authorIP'])) $this->authorIP = $fields['authorIP'];
		if (isset($fields['points'])) $this->points = $fields['points'];
		if (isset($fields['flagApproved'])) $this->flagApproved = $fields['flagApproved'];
		if (isset($fields['updateTime'])) $this->updateTime = $fields['updateTime'];
		if (isset($fields['createTime'])) $this->createTime = $fields['createTime'];
	
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
