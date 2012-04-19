<?php
require('class_oauthtwitter.php');

$oauth = new OAuthTwitter(
	array(
		'id' => 'API_ID',
		'secret' => 'API_KEY',
		'callback' => 'http://demo.thinphp.com/app/ext/authentication/src/oauth_twitter.php?step=callback',
	)
);

function process($oauth)
{
	$s = $oauth->fetch('http://api.twitter.com/1/account/verify_credentials.xml', 'GET');	
	$_SESSION['user'] = $s['user']['name'];
	header('Location: /');
}

require('oauth_inc.php');
?>