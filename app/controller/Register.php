<?php
defined('BASE') or exit('No direct script access allowed!');
require_once BASE.'/app/model/User.php';
require_once BASE . '/app/model/base/DAO.php';

class Register extends BaseController
{
	public function validate($retType)
	{
		parent::validate($retType);

		copy_fields($_POST, $fv, F_ENCODE, 'username', 'email', 'password', 'cpassword');

		if (trim($fv['username']) == '') {
			$rets[] = array('msg' => 'Please enter your username!', 'field' => 'username');
		}
		if (filter_var($fv['email'], FILTER_VALIDATE_EMAIL) === FALSE) {
    		$rets[] = array('msg' => 'Invalid email address!', 'field' => 'email');
        }
        if ($fv['password'] == '') {
			$rets[] = array('msg' => 'Please enter your password!', 'field' => 'password');
		}
		if (strlen($fv['password']) < 3) {
			$rets[] = array('msg' => 'Password must have at least 3 chars!', 'field' => 'password');
		}
		if ($fv['password'] != $fv['cpassword']) {
			$rets[] = array('msg' => 'Passwords mismatched!', 'field' => 'cpassword');
		}

		if (isset($rets)) {
	        if (isset($retType) && $retType == RT_JSON) {
	        	return header_json($rets);
	        } else {
	        	return $rets;
	        }
	    }
	}
	
	public function processPOST()
	{
		parent::processPOST();
		
		// #TODO: User submitted data. Save it to DB, email, etc.		
		copy_fields($_POST, $fv, F_ENCODE, 'username', 'email', 'password', 'cpassword');

		$dao = DAO::getDAO('UserDAO');
		$newUser = new User(
						array('firstName' => 'First', 'lastName' => 'LastName',
							'username' => $fv['username'], 'email' => $fv['email'], 'password' => $fv['password'])
					);
		$dbNow = date( 'Y-m-d H:i:s' );
		$ret = $dao->execute("INSERT INTO user(firstName, lastName, username, email, password, createTime)
					VALUES(:firstName, :lastName, :username, :email, :password, '$dbNow')", $newUser->getFields());		
		if ((int)$ret[0] > 0) $err = "<span class='msgErr'>ERROR: $ret[2]</span>";

		$v = $this->smarty;
		$v->assign('title', 'Thank you!');
		$v->assign('content', '<h2>Thank you!</h2><p>Thanks for your registration.</p><p>'.$err.'<p/><p><a href="/user-list">Check User List</a><p/>');
		$v->assign('inc_content', 'blank.html');
		$this->display($v, v('index.html'));
	}

	public function view()
	{
		if ($this->isValidating()) return $this->validate(RT_JSON);
		if ($this->isPosting()) return $this->processPOST();
		
		// show Register Form
		$v = $this->smarty;
		$v->assign('title', 'Register');
		$v->assign('inc_content', v('register.html'));

		$this->display($v, v('index.html'));
	}
}
