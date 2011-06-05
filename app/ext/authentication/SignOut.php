<?php
defined('BASE') or exit('Direct script access is not allowed!');
require_once BASEEXT.'/authentication/util.php';

class SignOut extends BaseController
{
	public function view()
	{
		session_start();
		logoutUser();
		
		header('Location: '.$_SERVER['HTTP_REFERER']);
	}
}
