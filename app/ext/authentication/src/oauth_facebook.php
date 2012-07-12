<?php
require('class_oauthfacebook.php');

$oauth = new OAuthFacebook(
	array(
		'id' => 'YOUR_API_ID',
		'secret' => 'YOUR_API_SECRET',
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
