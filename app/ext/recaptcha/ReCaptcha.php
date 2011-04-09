<?php
defined('BASE') or exit('Direct script access is not allowed!');
require_once BASE.'/app/ext/recaptcha/recaptcha-php-1.11/recaptchalib.php';

class ReCaptcha extends BaseController
{
	public static function checkAnswer()
	{		
		// global private key of ThinPHP subscription from reCAPTCHA. You can use this.
		$privatekey = "6LfUVcISAAAAABtSNKYdZIcbfo8-_qA5kkg8ONPM";
		$resp = recaptcha_check_answer ($privatekey,
		                            $_SERVER["REMOTE_ADDR"],
		                            $_POST["recaptcha_challenge_field"],
		                            $_POST["recaptcha_response_field"]);

		return $resp->is_valid;
	}
	
	public function view()
	{
		// global public key of ThinPHP subscription from reCAPTCHA. You can use this.
		$publickey = "6LfUVcISAAAAAKjd1Mf0XiDTGaa2cjd9DT3uur9X";
		$customScript = "<script type=\"text/javascript\">var RecaptchaOptions = { theme : 'clean' };</script>";
		echo $customScript . recaptcha_get_html($publickey);
	}
}
?>