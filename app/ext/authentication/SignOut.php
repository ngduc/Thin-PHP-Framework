<?php
defined('BASE') or exit('Direct script access is not allowed!');

class SignOut extends BaseController
{
	public function view()
	{
		session_start();
		unset($_SESSION['user']);
		
		header('Location: '.$_SERVER['HTTP_REFERER']);
	}
}
?>