<?php

/**
 * get logged in Username, session_start() must be called before using this!
 */
function getLoggedInUsername() {
	global $ext_i;
	$ssv = $ext_i['ext_auth_login_username_session'];
	$s = '';
	if (isset($_SESSION[$ssv]) && strlen($_SESSION[$ssv]) >0) $s = $_SESSION[$ssv];
	return $s;
}

/**
 * set logged in Username, session_start() must be called before using this!
 */
function setLoggedInUsername($username) {
	global $ext_i;
	$ssv = $ext_i['ext_auth_login_username_session'];	
	$_SESSION[$ssv] = $username;
}

/**
 * set logged in Username, session_start() must be called before using this!
 */
function logoutUser($username) {
	global $ext_i;
	$ssv = $ext_i['ext_auth_login_username_session'];	
	unset($_SESSION[$ssv]);
}
