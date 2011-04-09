<?php
defined('BASE') or exit('Direct script access is not allowed!');

class MathCaptcha extends BaseController
{
	public static function checkAnswer($answer)
	{		
		if( isset( $answer ) )
		{
			session_start();
			if($answer != $_SESSION['mathcaptcha_security_number'])
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
		require_once BASE.'/app/ext/mathcaptcha/image.php';
	}
}
?>