<?php
defined('BASE') or exit('Direct script access is not allowed!');

class SignIn extends BaseController
{
	public function validate($retType)
	{		
		parent::validate($retType);
		copy_fields($_POST, $fv, F_ENCODE, 'username');

		if (validate_username($fv['username']) == false) {
			$rets[] = array('msg' => '<br/>Invalid username!', 'field' => 'username');
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

		copy_fields($_POST, $fv, F_ENCODE, 'username', 'password');
		// #TODO: check Username & Password from DB
		if ($fv['password'] == 'demo') {	// successfully signed in!					
			$ret = session_start();
			$_SESSION['user'] = $fv['username'];			
			header('Location: '.$_SERVER['HTTP_REFERER']);
		}
		else {			
			$msg = '<font color="red">Invalid Username or Password!</font><p/> <a href="javascript:history.go(-1)">Go back</a>';

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
		if ($this->isPosting()) return $this->processPOST();

		$ret = session_start();

		if (isset($_SESSION['user']) && strlen($_SESSION['user']) > 0) {
			echo('Welcome! '.$_SESSION['user']);
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
?>