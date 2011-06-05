<?php

/**
 * get logged in Username, session_start() must be called before using this!
 */
function getMathCaptchaAnswer() {
	global $ext_i;
	$ssv = $ext_i['mathcaptcha_security_session'];
	$s = '';
	if (isset($_SESSION[$ssv]) && strlen($_SESSION[$ssv]) >0) $s = $_SESSION[$ssv];
	return $s;
}

/**
 * set logged in Username, session_start() must be called before using this!
 */
function setMathCaptchaAnswer($s) {
	global $ext_i;
	$ssv = $ext_i['mathcaptcha_security_session'];	
	$_SESSION[$ssv] = $s;
}

function unsetMathCaptchaAnswer() {
	global $ext_i;
	$ssv = $ext_i['mathcaptcha_security_session'];	
	unset($_SESSION[$ssv]);
}
