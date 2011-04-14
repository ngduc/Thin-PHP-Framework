<?php
defined('BASE') or exit('No direct script access allowed!');
require_once BASE.'/app/model/base/BaseBO.php';

/**
 * Auto generated Model Class represents table 'user' 
 * @author: Thin PHP Framework
 * @date: 2011-04-14 03:29
 */
class User extends BaseBO
{
	private $fields;
	private $userId;
	private $email;
	private $username;
	private $password;
	private $oauthProvider;
	private $oauthUid;
	private $oauthUsername;
	private $firstName;
	private $lastName;
	private $website;
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
		$this->userId = $fields['userId'];
		$this->email = $fields['email'];
		$this->username = $fields['username'];
		$this->password = $fields['password'];
		$this->oauthProvider = $fields['oauthProvider'];
		$this->oauthUid = $fields['oauthUid'];
		$this->oauthUsername = $fields['oauthUsername'];
		$this->firstName = $fields['firstName'];
		$this->lastName = $fields['lastName'];
		$this->website = $fields['website'];
		$this->createTime = $fields['createTime'];
	
	}

	public function getFields() {
		return $this->fields;
	}

	
	public function getUserId() {
		return $this->userId;
	}
	public function setUserId($userId) {
		$this->userId = $userId;
	}

	public function getEmail() {
		return $this->email;
	}
	public function setEmail($email) {
		$this->email = $email;
	}

	public function getUsername() {
		return $this->username;
	}
	public function setUsername($username) {
		$this->username = $username;
	}

	public function getPassword() {
		return $this->password;
	}
	public function setPassword($password) {
		$this->password = $password;
	}

	public function getOauthProvider() {
		return $this->oauthProvider;
	}
	public function setOauthProvider($oauthProvider) {
		$this->oauthProvider = $oauthProvider;
	}

	public function getOauthUid() {
		return $this->oauthUid;
	}
	public function setOauthUid($oauthUid) {
		$this->oauthUid = $oauthUid;
	}

	public function getOauthUsername() {
		return $this->oauthUsername;
	}
	public function setOauthUsername($oauthUsername) {
		$this->oauthUsername = $oauthUsername;
	}

	public function getFirstName() {
		return $this->firstName;
	}
	public function setFirstName($firstName) {
		$this->firstName = $firstName;
	}

	public function getLastName() {
		return $this->lastName;
	}
	public function setLastName($lastName) {
		$this->lastName = $lastName;
	}

	public function getWebsite() {
		return $this->website;
	}
	public function setWebsite($website) {
		$this->website = $website;
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
		return ''.':'.$this->userId.':'.$this->email.':'.$this->username.':'.$this->password.':'.$this->oauthProvider.':'.$this->oauthUid.':'.$this->oauthUsername.':'.$this->firstName.':'.$this->lastName.':'.$this->website.':'.$this->createTime;
	}
}
?>