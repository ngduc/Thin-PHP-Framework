<?php
require_once(dirname(__FILE__) . '/class_oauth.php');

class OAuthGoogle extends OAuthHelper {
	public function __construct($config) {
		$system = array(
			'requires' => array(
				'id' => true,
				'secret' => false,
				'access_token' => false,
				'acess_token_secret' => false,
				'private_key' => false,
				'public_key' => false,
				'callback' => true,
				'scope' => true,
			),
			'legs' => array(
				'request_token' => 'https://www.google.com/accounts/OAuthGetRequestToken?scope=$info[scope]',
				'authorize' => 'https://www.google.com/accounts/OAuthAuthorizeToken?oauth_token=$info[request_token]',
				'access_token' => 'https://www.google.com/accounts/OAuthGetAccessToken',
			),
			'use_auth_header' => true,
			'version' => '1.0',
		);
		parent::__construct($system,$config);
		
		$this->default_parse_mode = 'xml';
	}
	
	public static function scopes() {
		$scopes = array(
			'analytics' => 'https://www.google.com/analytics/feeds/',
			'base' => 'http://www.google.com/base/feeds/',
			'books' => 'http://www.google.com/books/feeds/',
			'blogger' => 'http://www.blogger.com/feeds/',
			'calendar' => 'http://www.google.com/calendar/feeds/',
			'contacts' => 'http://www.google.com/m8/feeds/',
			'docs' => 'http://docs.google.com/feeds/',
			'finance' => 'http://finance.google.com/finance/feeds/',
			'gmail' => 'https://mail.google.com/mail/feed/atom',
			'health' => 'https://www.google.com/health/feeds/',
			'h9' => 'https://www.google.com/h9/feeds/',
			'maps' => 'http://maps.google.com/maps/feeds/',
			'moderator' => 'tag:google.com,2010:auth/moderator',
			'opensocial' => 'http://www-opensocial.googleusercontent.com/api/people/',
			'orkut' => 'http://www.orkut.com/social/rest',
			'picasa' => 'http://picasaweb.google.com/data/',
			'sidewiki' => 'http://www.google.com/sidewiki/feeds/',
			'sites' => 'http://sites.google.com/feeds/',
			'spreadsheets' => 'http://spreadsheets.google.com/feeds/',
			'webmastertools' => 'http://www.google.com/webmasters/tools/feeds/',
			'youtube' => 'http://gdata.youtube.com',
		);
		
		$services = func_get_args();
		$return = array();
		foreach ($services as $service) {
			if (isset($scopes[$service])) 
				$return[$service] = $scopes[$service];
		}
		return implode(' ',$return);
	}
}
?>