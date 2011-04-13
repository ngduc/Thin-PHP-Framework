<?php
defined('BASE') or exit('No direct script access allowed!');
require_once BASE.'/app/model/base/BaseBO.php';

/**
 * Auto generated Model Class represents table 'post' 
 * @author: Thin PHP Framework
 * @date: 2011-04-12 22:09
 */
class Post extends BaseBO
{
	private $fields;
	private $postId;
	private $title;
	private $description;
	private $allowComment;
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
		$this->title = $fields['title'];
		$this->description = $fields['description'];
		$this->allowComment = $fields['allowComment'];
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

	public function getAllowComment() {
		return $this->allowComment;
	}
	public function setAllowComment($allowComment) {
		$this->allowComment = $allowComment;
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
		return ''.':'.$this->postId.':'.$this->title.':'.$this->description.':'.$this->allowComment.':'.$this->updateTime.':'.$this->createTime;
	}
}
?>