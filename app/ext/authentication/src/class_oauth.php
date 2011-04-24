<?php
require_once(dirname(__FILE__).'/OAuth/OAuth.php');

define('OAUTH_PERMISSION_READ',1);
define('OAUTH_PERMISSION_WRITE',2);

abstract class OAuthHelper {
	public $debug = false;
	protected $default_parse_mode = 'xml';
	
	private $system = null;
	private $errors = array();
	private $authorize_uri = '';
	private $consumer = null; //1.0 only
	private $access_token = null; //1.0 only
	
	public $http_code = null;
	
	public function __construct($system,$config) {
		$this->system = $system;
		$this->system['info'] = array();
		foreach ($this->system['requires'] as $field => $required) {
			$this->system['info'][$field] = @$config[$field];
			if ($required && empty($this->system['info'][$field])) {
				trigger_error('OAuth Configuration Missing: ' . $field,E_USER_ERROR);
			}
		}
		
		if ($this->system['version'] == '1.0') {
			$this->consumer = new OAuthConsumer($this->system['info']['id'],$this->system['info']['secret'],$this->system['info']['callback']);
		}
		
		if ($this->system['info']['access_token']) $this->setAccessToken($this->system['info']['access_token'],@$this->system['info']['access_token_secret']);
	}
	
	public function setAccessToken($token,$secret = '') {
		$this->system['info']['access_token'] = $token;
		$this->system['info']['access_token_secret'] = $secret;
		if ($this->system['version'] == '1.0') $this->access_token = new OAuthConsumer($token,$secret);
	}
	
	public function authorized() {
		//very basic check
		//should be override
		return !empty($this->system['info']['access_token']);
	}
	
	public function getInfo() {
		return $this->system['info'];
	}
	
	public function getErrors() {
		return $this->errors;
	}
	
	private function prepareURI($pattern) {
		$info = array();
		foreach ($this->system['info'] as $key => $value) {
			$info[$key] = urlencode($value);
		}
		eval('$uri = "' . $pattern . '";');
		return $uri;
	}
	
	private function getRequestToken() {
		//OAuth 1.0 only
		
		$this->errors = array();
		
		$uri = $this->prepareURI($this->system['legs']['request_token']);
		$token = $this->fetch($uri,'GET',array('oauth_callback' => $this->system['info']['callback']),'param');
		
		if (is_array($token)) {
			if (!empty($token['oauth_token'])) {
				$this->system['info']['request_token'] = $token['oauth_token'];
			} else {
				$this->errors[] = 'Unable to get Request Token from response';
			}
		} else {
			$this->errors[] = 'Unable to get Request Token from URI: ' . $uri;
		}
		
		return empty($this->errors);
	}
	
	public function buildAuthorizeURI() {
		$this->errors = array();
		
		switch ($this->system['version']) {
			case '1.0':
				if ($this->getRequestToken()) {
					return $this->prepareURI($this->system['legs']['authorize']);
				}
				break;
			case '2.0':
				return $this->prepareURI($this->system['legs']['authorize']);
				break;
		}
		
		if (empty($this->errors)) {
			return $this->authorize_uri;
		} else {
			return false;
		}
	}
	
	public function getAccessToken() {
		$this->errors = array();
		
		if (is_array($this->system['legs']['callback'])) 
			foreach ($this->system['legs']['callback'] as $key)
				$this->system['info'][$key] = @$_GET[$key];
		$uri = $this->prepareURI($this->system['legs']['access_token']);
		$access_token_key = '';
		
		switch ($this->system['version']) {
			case '1.0':
				$this->setAccessToken($_GET['oauth_token']);
				$token = $this->fetch($uri,'GET',array('oauth_verifier'=>$_GET['oauth_verifier']),'param');
				$access_token_key = 'oauth_token';
				break;
			case '2.0':
				$token = $this->fetch($uri,'GET',array(),'param');
				$access_token_key = 'access_token';
				break;
		}
		
		if (is_array($token)) {
			if (!empty($token[$access_token_key])) {
				$this->setAccessToken($token[$access_token_key],@$token['oauth_token_secret']);
			} else {
				$this->errors[] = 'Unable to get Access Token from response';
			}
		} else {
			$this->errors[] = 'Unable to get Access Token from URI: ' . $uri;
		}
		
		return empty($this->errors);
	}
	
	public function fetch($uri,$method,$parameters = array(),$parse_mode = null,$expect_http_code = 200) {
		switch ($this->system['version']) {
			case '1.0':
				$request = OAuthRequest::from_consumer_and_token(
					$this->consumer
					, $this->access_token
					, $method
					, $uri
					, $parameters
				);
				
				if ($this->system['info']['secret'] === false) {
					$request->sign_request(new SystemBasedOAuthSignatureMethod_RSA_SHA1($this->system['info']), $this->consumer, $this->access_token);
				} else {
					$request->sign_request(new OAuthSignatureMethod_HMAC_SHA1(), $this->consumer, $this->access_token);
				}
				
				$this->debug('BASE STRING: ' . $request->get_signature_base_string());
		
				if ($this->system['use_auth_header']) {
					$response_raw = $this->sendRequest($uri, $method, $request->to_postdata(), array($request->to_header()));
				} else {
					$response_raw = $this->sendRequest($request->to_url(), $method, $request->to_postdata());
				}
				break;
			case '2.0':
				if ($this->system['info']['access_token']) {
					if (strpos($uri,'?') === false) {
						$uri .= '?';
					} else {
						$uri .= '&';
					}
					$uri .= 'access_token=' . $this->system['info']['access_token'];
				}
				$response_raw = $this->sendRequest($uri,$method,$parameters);
				break;
		}
		
		if (!is_numeric($expect_http_code) OR $expect_http_code == $this->http_code) {
			$response = false;
			if ($parse_mode === null) $parse_mode = $this->default_parse_mode;
			switch ($parse_mode) {
				case 'xml':
					$this->debug('Parsing as XML');
					$response = OAuthHelper::parse_xml($response_raw);
					break;
				case 'json':
					$this->debug('Parsing as JSON');
					$response = OAuthHelper::parse_json($response_raw);
					break;
				case 'param':
					$this->debug('Parsing as Parametters');
					parse_str($response_raw,$response);
					break;
				case 'none':
					$this->debug('No parsing!');
					$response = $response_raw;
					break;
				case 'custom':
				default:
					$this->debug('Calling custom parsing method');
					$response = $this->parse_response($response_raw,$parse_mode);
					break;
			}
		} else {
			$this->debug('UNEXPECTED HTTP CODE: ' . $this->http_code . ' (SHOULD BE ' . $expect_http_code . ')');
			$response = $response_raw;
		}
		
		$this->debug('Response: <pre>' . var_export($response,true) . '</pre><hr/>');
		return $response;
	}
	
	private function sendRequest($uri, $method, $postfields = null, $headers = null) {
		$this->http_info = array();
		$ci = curl_init();
		curl_setopt($ci, CURLOPT_CONNECTTIMEOUT, 30);
		curl_setopt($ci, CURLOPT_TIMEOUT, 30);
		curl_setopt($ci, CURLOPT_RETURNTRANSFER, true);
		if (!empty($headers)) curl_setopt($ci, CURLOPT_HTTPHEADER, $headers);
		switch ($method) {
			case 'POST':
				curl_setopt($ci, CURLOPT_POST, true);
				if (!empty($postfields)) {
					curl_setopt($ci, CURLOPT_POSTFIELDS, $postfields);
				}
				break;
			case 'DELETE':
			case 'PUT':
				curl_setopt($ci, CURLOPT_CUSTOMREQUEST, $method);
				if (!empty($postfields)) {
					$uri= "{$uri}?{$postfields}";
				}
		}
		curl_setopt($ci, CURLOPT_URL, $uri);
		
		$response = curl_exec($ci);
		$this->http_code = curl_getinfo($ci, CURLINFO_HTTP_CODE);
		curl_close ($ci);
		
		if ($this->debug) {
			$this->debug('<h2>sendRequest</h2>');
			$this->debug('URI: ' . $uri);
			$this->debug('METHOD: ' . $method);
			$this->debug('POSTFIELDS: ' . nl2br(var_export($postfields,true)));
			$this->debug('HEADERS: ' . nl2br(var_export($headers,true)) . '<hr/>');
			$this->debug('HTTP CODE: ' . $this->http_code);
			$this->debug('RESPONSE: <pre>' . htmlentities($response) . '</pre><hr/>');
		}
		
		return $response;
	}
	
	protected function parse_response($raw,$mode) {
		return false;
	}
	
	public static function parse_xml($xml) {
		if (!function_exists('xml2array')) require_once(dirname(__FILE__) . '/xml2array/xml2array.php');
		return xml2array($xml);
	}
	
	public static function parse_json($json) {
		if (!class_exists('Services_JSON')) require_once(dirname(__FILE__) . '/JSON/JSON.php');
		//original source code from jsonwrapper_inner.php
		//of Facebook SDK
		global $services_json;
		if (!isset($services_json)) {
			$services_json = new Services_JSON(SERVICES_JSON_LOOSE_TYPE);
		}
		return $services_json->decode($json);
	}
	
	protected function debug($message) {
		if ($this->debug) {
			echo $message, '<br/>';
		}
	}
}

class SystemBasedOAuthSignatureMethod_RSA_SHA1 extends OAuthSignatureMethod_RSA_SHA1 {
	var $systemconfig = array();
	
	public function __construct($systemconfig) {
		$this->systemconfig = $systemconfig;
	}
	
	public function fetch_private_cert(&$request) {
		return $this->systemconfig['private_key'];
	}
	
	public function fetch_public_cert(&$request) {
		return $this->systemconfig['public_key'];
	}
} 
