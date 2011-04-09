<?php
require_once(dirname(__FILE__) . '/class_oauth.php');

class OAuthTwitter extends OAuthHelper {
	public function __construct($config) {
		$system = array(
			'requires' => array(
				'id' => true,
				'secret' => true,
				'access_token' => false,
				'access_token_secret' => false,
				'private_key' => false,
				'public_key' => false,
				'callback' => false,
			),
			'legs' => array(
				'request_token' => 'http://twitter.com/oauth/request_token',
				//'authorize' => 'http://twitter.com/oauth/authorize?oauth_token=$info[request_token]',
				'authorize' => 'http://twitter.com/oauth/authenticate?oauth_token=$info[request_token]', //use this to make the process as fast as possible
				'access_token' => 'http://twitter.com/oauth/access_token',
			),
			'use_auth_header' => false,
			'version' => '1.0',
		);
		parent::__construct($system,$config);
		
		$this->default_parse_mode = 'xml';
	}
}
?>