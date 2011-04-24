<?php
session_start();
$session_prefix = md5($_SERVER['SCRIPT_NAME']) . '_';

if (isset($_REQUEST['refresh'])) {
	session_unset();
} else if (isset($_REQUEST['access_token'])) {
	$_SESSION[$session_prefix . 'access_token'] = $_REQUEST['access_token'];
}

if (isset($_SESSION[$session_prefix . 'access_token'])) {
	$oauth->setAccessToken($_SESSION[$session_prefix . 'access_token'],$_SESSION[$session_prefix . 'access_token_secret']);
}

if (!$oauth->authorized()) {
	if ($_REQUEST['step'] == 'callback') {
		if ($oauth->getAccessToken()) {
			$info = $oauth->getInfo();
			$_SESSION[$session_prefix . 'access_token'] = $info['access_token'];
			$_SESSION[$session_prefix . 'access_token_secret'] = $info['access_token_secret'];

			process($oauth); // defined in caller's script
		} else {
			die('Error!');
			//var_dump($oauth->getErrors());
		}
	} else {
		$uri = $oauth->buildAuthorizeURI();
		if ($uri)
		{
			//echo '<a href="',$uri,'">',$uri,'</a>';
			header("Location: $uri");
		}
		else {
			die('Error!');
			//var_dump($oauth->getErrors());
		}
	}
}

