<?php
require('class_oauthfacebook.php');

$oauth = new OAuthFacebook(
	array(
		'id' => 'API_ID',
		'secret' => 'API_SECRET',
		'callback' => 'http://demo.thinphp.com/app/ext/authentication/src/oauth_facebook.php?step=callback',
		'scope' => 'user_about_me,email'
	)
);

function process($oauth)
{
	$s = $oauth->fetch('https://graph.facebook.com/me', 'GET');
	$_SESSION['user'] = $s['name'];
	header('Location: /');
}

require('oauth_inc.php');
?>