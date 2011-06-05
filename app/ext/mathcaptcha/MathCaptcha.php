<?php
defined('BASE') or exit('Direct script access is not allowed!');
require_once BASEEXT.'/mathcaptcha/util.php';

class MathCaptcha extends BaseController
{
	public static function checkAnswer($answer)
	{		
		if( isset( $answer ) )
		{
			session_start();
			if(getMathCaptchaAnswer() != $answer)
			{
				// $error = "OOOK! Here's what you must do: click Start -> Run and write calc.";
				return false;
			}
			else
			{
				// $error = "Man, you're good! Your result is correct.";
				return true;
			}
		}
		return false;
	}
	
	public function view()
	{
		require_once BASEEXT.'/mathcaptcha/src/image.php';
	}
}
