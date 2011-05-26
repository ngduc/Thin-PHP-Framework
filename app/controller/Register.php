<?php
defined('BASE') or exit('No direct script access allowed!');
require_once BASE.'/app/model/User.php';
require_once BASE.'/app/model/base/DAO.php';

class Register extends BaseController
{
	public function validate($retType)
	{
		parent::validate($retType);

		copyItems($_POST, $v, '*');

		if (trim($v['username']) == '') {
			$rets[] = array('msg' => 'Please enter your username!', 'field' => 'username');
		}
		if (filter_var($v['email'], FILTER_VALIDATE_EMAIL) === FALSE) {
    		$rets[] = array('msg' => 'Invalid email address!', 'field' => 'email');
        }
        if ($v['password'] == '') {
			$rets[] = array('msg' => 'Please enter your password!', 'field' => 'password');
		}
		if (strlen($v['password']) < 3) {
			$rets[] = array('msg' => 'Password must have at least 3 chars!', 'field' => 'password');
		}
		if ($v['password'] != $v['cpassword']) {
			$rets[] = array('msg' => 'Passwords mismatched!', 'field' => 'cpassword');
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
		
		// #TODO: User submitted data. Save it to DB, email, etc.
		copyItems($_POST, $v, '*');

		$dao = DAO::getDAO('UserDAO');
		$newUser = new User(
						array('firstName' => 'First', 'lastName' => 'LastName',
							'username' => $v['username'], 'email' => $v['email'], 'password' => $v['password'])
					);
		$dbNow = date( 'Y-m-d H:i:s' );
		$ret = $dao->execute("INSERT INTO user(firstName, lastName, username, email, password, createTime)
					VALUES(:firstName, :lastName, :username, :email, :password, '$dbNow')", $newUser->getFields());
		if ($ret[0] != '00000') $err = "<span class='msgErr'>ERROR: $ret[2]</span>";

		$v = $this->smarty;
		$v->assign('title', 'Thank you!');
		$v->assign('content', '<h2>Thank you!</h2><p>Thanks for your registration.</p><p>'.$err.'<p/><p><a href="/user-list">Check User List</a><p/>');
		$v->assign('inc_content', 'blank.html');
		$this->display($v, v('index.html'));
	}

	public function view()
	{
		if ($this->isValidating()) return $this->validate(RT_JSON);
		if ($this->isPosting()) return $this->processPost();
		
		// show Register Form
		$v = $this->smarty;
		$v->assign('title', 'Register');
		$v->assign('inc_content', v('register.html'));

		$this->display($v, v('index.html'));
	}
}
