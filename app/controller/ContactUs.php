<?php
defined('BASE') or exit('No direct script access allowed!');
require_once BASE.'/app/ext/recaptcha/ReCaptcha.php';

class ContactUs extends BaseController
{
	public function validate($retType)
	{
		parent::validate($retType);

		copyArray($_POST, $fv, 'name', 'email', 'msg');

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

		if (isset($retType) && $retType == RT_JSON && isset($rets)) return outputJson($rets);
        return $rets;
	}
	
	public function processPost()
	{
		parent::processPost();
		session_start();
		// #TODO: User submitted data. Save it to DB, email, etc.
		copyArray($_POST, $fv, 'ftoken', 'name', 'email', 'optin|checkbox', 'msg');
		
		checkFormToken('ftoken_contact_us', $fv['ftoken']);		

		$v = $this->smarty;
		$v->assign('title', 'Thank you!');
		$v->assign(array(
				'name' => sanitizeString($fv['name']),
				'email' => sanitizeEmail($fv['email']),
				'optin' => $fv['optin']
		));
		$v->assign('inc_content', v('contact_us_done.html'));
		$this->display($v, v('index.html'));
	}

	public function view()
	{
		if ($this->isValidating()) return $this->validate(RT_JSON);
		if ($this->isPosting()) return $this->processPost();		
		session_start();
		
		$v = $this->smarty;
		$v->assign('title', 'Contact Us');
		$v->assign('inc_content', v('contact_us.html'));
		$v->assign('ftoken', genFormToken('ftoken_contact_us'));
		$this->display($v, v('index.html'));
	}
}
