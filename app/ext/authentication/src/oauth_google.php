<?php
require('class_oauthgoogle.php');

// --- PASTE YOUR KEYS HERE --- //

$private_key = <<<EOF
-----BEGIN RSA PRIVATE KEY-----
MIICXAIBAAKBgQCxwlbRW6aox6/vJMBNx5rlGIglqkquqW6sY1hS5YWbnY02KZr1
4cKtKxlzeSLp5zsHlsIqq2cRhfgd4ocSsPPEBL+hDvZ+hf6ykvuMUw8Phu+m9UQg
flasjldajfijslkjfaldsajflkdjshn6spN9y5aU2A67FbhCR3fbiHBUoQIDAQAB
AoGAGTukBU4ER1spP0IxRhk6hKDJ2sbkmQyWGER16jaIk8F2pSScyaCFeP1wPHMK
oLdhKr+cyl/QXq1svhlE4UNbJtCGHPr+R96Vtjq62Pf7t/ZsIVMhJdzrEITzXJxD
1dlxsI/VfajhGRTkNip4cor1fOZUa9FTLYpB4WhpOPex3U0CQQDdrat4C31WpKkI
38+Dc1pDWBzkYhoq0QD3DsyH9KVaI+7strbjOZ+gLbMfn4TpS9dtjnMsR9ZKKyBe
vW1ZAqgTAkEAzUfog/p5OOJr7oT5hTVJnBZZaC89YBSuafFgHAgQq3QkJuRl6dza
bCjFTSph4SonirZRAkstLtoqIQNCmVmO+wJAP4zeL1f74q7p1qVy9BhJtCy6e660
Gbo5MJqJgCBeluzePfZTj+ihHmZ7h4FPtSIM7Fd+JR+jCzg5228qve3JCQJAbK5a
aq1MSpKNg/1AwYahzxKCCUehXeH1KT/Sm2SltrBJh5G6ZyM3PLYlJyJ+KaCQyL6X
ivhUFo8IaOv58YhZywJBANhgZBTITngaSdEL2IbtSxfm/kLNKi+LqBrXGuxLKfjj
XtSdMrU3hKHSSCEI9VyLtsn45QWRB4nScfZxEvcEuwU=
-----END RSA PRIVATE KEY-----
EOF;

$public_key = <<<EOF
-----BEGIN CERTIFICATE-----
MIICyDCCAjGgAwIBAgIJAKIMYtsMjN/+MA0GCSqGSIb3DQEBBQUAME0xCzAJBgNV
fajlsdjflksajlkfjsakljflksjflksjA1UEBxMNTW91bnRhaW4gVmlldzEZMBcG
A1UEAxMQZGVtby50aGlucGhwLmNvbTAeFw0xMTA0MDMwOTIyNDlaFw0xMjA0MDIw
OTIyNDlaME0xCzAJBgNVBAYTAlVTMQswCQYDVQQIEwJDQTEWMBQGA1UEBxMNTW91
bnRhaW4gVmlldzEZMBcGA1UEAxMQZGVtby50aGlucGhwLmNvbTCBnzANBgkqhkiG
9w0BAQEFAAOBjQAwgYkCgYEAscJW0VumqMev7yTATcea5RiIJapKrqlurGNYUuWF
m52NNima9eHCrSsZc3ki6ec7B5bCKqtnEYX4HeKHErDzxAS/oQ72foX+spL7jFMP
D4bvpvVEIFDVDHkFR9h568y6qjE+hyscMw0r38YZ+rKTfcuWlNgOuxW4Qkd324hw
VKECAwEAAaOBrzCBrDAdBgNVHQ4EFgQUO7UMiEBSFf2pit66Up0RU2S4KEgwfQYD
VR0jBHYwdIAUO7UMiEBSFf2pit66Up0RU2S4KEihUaRPME0xCzAJBgNVBAYTAlVT
MQswCQYDVQQIEwJDQTEWMBQGA1UEBxMNTW91bnRhaW4gVmlldzEZMBcGA1UEAxMQ
ZGVtby50aGlucGhwLmNvbYIJAKIMYtsMjN/+MAwGA1UdEwQFMAMBAf8wDQYJKoZI
hvcNAQEFBQADgYEAqrx6/gMybqWQfzq26pG9ziFjZ5Ou5VQlzRCXgGL6hONzsFX+
PpvtwyHfFUFX+ydKGfqt60/6V4HAFkkN4Z9/57iMgCHeInaEpq+AS7hjyS2iRnq5
Hoj7ALKFxeIE4vqHbB5eslt9GdHSsAHMaOBsFwuj+EMaG8Stdlwak/TDcpA=
-----END CERTIFICATE-----
EOF;

$oauth = new OAuthGoogle(
	array(
		'id' => 'demo.thinphp.com',
		'secret' => false,
		'private_key' => $private_key,
		'public_key' => $public_key,
		'callback' => 'http://demo.thinphp.com/app/ext/authentication/src/oauth_google.php?step=callback',
		'scope' => OAuthGoogle::scopes('contacts'),
	)
);


function process($oauth)
{
	$s = $oauth->fetch('http://www.google.com/m8/feeds/contacts/default/base', 'GET');
	$_SESSION['user'] = $s['feed']['author']['name'];
	header('Location: /');
}

require('oauth_inc.php');
