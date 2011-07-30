<?php
defined('BASE') or exit('Direct script access is not allowed!');
require_once BASEEXT.'/authentication/util.php';
require_once BASE.'/app/model/User.php';
require_once BASE.'/app/model/base/DAO.php';

class SignIn extends BaseController
{
	public function validate($retType)
	{
		parent::validate($retType);
		copyArray($_POST, $fv, 'username');

		if (validateUsername($fv['username']) == false) {
			$rets[] = array('msg' => '<br/>Invalid username!', 'field' => 'username');
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
			
		copyArray($_POST, $fv, 'username', 'password');
    $userDao = DAO::getDAO('UserDAO');
    $user = $userDao->getFirstByField('username', $fv['username']);

		// #TODO: check Username & Password from DB
		if (md5($fv['password']) == $user['password']) {	// successfully signed in!
			$ret = session_start();
			setLoggedInUsername( $fv['username'] );
			header('Location: '.$_SERVER['HTTP_REFERER']);
		}
		else {	
			$msg = '<font color="red">Invalid Username or Password!</font><p/> <a href="'
        . $_SERVER['HTTP_REFERER'] . '">Go back</a>';

			$v = $this->smarty;
			$v->assign('title', 'Contact Us');
			$v->assign('hide_signin', '1'); // MUST hide signin, otherwise it will cause infinite loop!!!
			$v->assign('inc_content', BASEEXT.'/authentication/view/signin_msg.html');
			$v->assign('message', $msg);
			$this->display($v, v('index.html'));
		}
	}

	public function view()
	{		
		if ($this->isValidating()) return $this->validate(RT_JSON);
		if ($this->isPosting() && $_POST['form']=='signinForm') return $this->processPost();

		$ret = session_start();

		if (getLoggedInUsername() != '') {
			echo('Welcome! '.getLoggedInUsername());
			echo('<p/><a href="/sign-out">Sign out</a>');
		}
		else {
			// show Signin Form
			$v = $this->smarty;
			$v->setTemplateDir(BASEEXT.'/authentication/view');
			$this->display($v, 'signin_form.html');
		}		
	}
}
