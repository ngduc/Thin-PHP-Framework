<?php
defined('BASE') or exit('No direct script access allowed!');
require_once BASE.'/app/model/base/BaseBO.php';

/**
 * Auto generated Model Class represents table 'post' 
 * @author: Thin PHP Framework
 * @date: 2011-04-23 17:16
 */
class Post extends BaseBO
{
	private $fields;
	private $postId;
	private $authorId;
	private $title;
	private $description;
	private $content;
	private $views;
	private $points;
	private $flagLocked;
	private $flagHideComments;
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
		$this->postId = $fields['postId'];
		$this->authorId = $fields['authorId'];
		$this->title = $fields['title'];
		$this->description = $fields['description'];
		$this->content = $fields['content'];
		$this->views = $fields['views'];
		$this->points = $fields['points'];
		$this->flagLocked = $fields['flagLocked'];
		$this->flagHideComments = $fields['flagHideComments'];
		$this->updateTime = $fields['updateTime'];
		$this->createTime = $fields['createTime'];
	
	}

	public function getFields() {
		return $this->fields;
	}

	
	public function getPostId() {
		return $this->postId;
	}
	public function setPostId($postId) {
		$this->postId = $postId;
	}

	public function getAuthorId() {
		return $this->authorId;
	}
	public function setAuthorId($authorId) {
		$this->authorId = $authorId;
	}

	public function getTitle() {
		return $this->title;
	}
	public function setTitle($title) {
		$this->title = $title;
	}

	public function getDescription() {
		return $this->description;
	}
	public function setDescription($description) {
		$this->description = $description;
	}

	public function getContent() {
		return $this->content;
	}
	public function setContent($content) {
		$this->content = $content;
	}

	public function getViews() {
		return $this->views;
	}
	public function setViews($views) {
		$this->views = $views;
	}

	public function getPoints() {
		return $this->points;
	}
	public function setPoints($points) {
		$this->points = $points;
	}

	public function getFlagLocked() {
		return $this->flagLocked;
	}
	public function setFlagLocked($flagLocked) {
		$this->flagLocked = $flagLocked;
	}

	public function getFlagHideComments() {
		return $this->flagHideComments;
	}
	public function setFlagHideComments($flagHideComments) {
		$this->flagHideComments = $flagHideComments;
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
		return ''.':'.$this->postId.':'.$this->authorId.':'.$this->title.':'.$this->description.':'.$this->content.':'.$this->views.':'.$this->points.':'.$this->flagLocked.':'.$this->flagHideComments.':'.$this->updateTime.':'.$this->createTime;
	}
}
