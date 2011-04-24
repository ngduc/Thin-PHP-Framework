<?php
defined('BASE') or exit('No direct script access allowed!');
require_once BASE.'/app/ext/recaptcha/ReCaptcha.php';

class ContactUs extends BaseController
{
	public function validate($retType)
	{
		parent::validate($retType);

		copy_fields($_POST, $fv, F_ENCODE, 'name', 'email', 'msg');

		if (trim($fv['name']) == '') {
			$rets[] = array('msg' => 'Please enter your name!', 'field' => 'name');
		}
		if (filter_var($fv['email'], FILTER_VALIDATE_EMAIL) === FALSE) {
    		$rets[] = array('msg' => 'Invalid email!', 'field' => 'email');
        }
        if (trim($fv['msg']) == '') {
			$rets[] = array('msg' => 'Please enter your message!', 'field' => 'msg');
		}
        if (ReCaptcha::checkAnswer() == false && isset($retType) && $retType == RT_JSON) {
        	$rets[] = array('msg' => 'The reCAPTCHA wasn\'t entered correctly!', 'field' => 'recaptcha');
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
		copy_fields($_POST, $fv, F_ENCODE, 'ftoken', 'name', 'email', 'optin|checkbox', 'msg');

		session_start();
		if($fv['ftoken'] != $_SESSION['ftoken']) die('Error: invalid form token! Do not submit your form twice.');
		unset($_SESSION['ftoken']);

		$v = $this->smarty;
		$v->assign('title', 'Thank you!');
		$v->assign(array(
				'name' => sanitize_str($fv['name']),
				'email' => sanitize_email($fv['email']),
				'optin' => $fv['optin']
			));
		$v->assign('inc_content', v('contact_us_done.html'));
		$this->display($v, v('index.html'));
	}

	public function view()
	{
		if ($this->isValidating()) return $this->validate(RT_JSON);
		if ($this->isPosting()) return $this->processPOST();
		
		// show Contact Us Form
		session_start();
		$_SESSION['ftoken'] = generateFormToken();
		
		$v = $this->smarty;
		$v->assign('title', 'Contact Us');
		$v->assign('inc_content', v('contact_us.html'));
		$v->assign('ftoken', $_SESSION['ftoken']);
		$this->display($v, v('index.html'));
	}
}

