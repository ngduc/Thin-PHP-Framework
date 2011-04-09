<?php
require_once(dirname(__FILE__) . '/class_oauth.php');

class OAuthFacebook extends OAuthHelper {
	public function __construct($config) {
		$system = array(
			'requires' => array(
				'id' => true,
				'secret' => true,
				'access_token' => false,
				'callback' => true,
				'scope' => false,
			),
			'legs' => array(
				'authorize' => 'https://graph.facebook.com/oauth/authorize?client_id=$info[id]&redirect_uri=$info[callback]&scope=$info[scope]',
				'callback' => array(
					'code',
				),
				'access_token' => 'https://graph.facebook.com/oauth/access_token?client_id=$info[id]&redirect_uri=$info[callback]&client_secret=$info[secret]&code=$info[code]',
			),
			'version' => '2.0',
		);
		parent::__construct($system,$config);
		
		$this->default_parse_mode = 'fb_json';
	}
	
	public function restapi($function,$method = 'GET',$args = array()) {
		$uri = 'https://api.facebook.com/method/' . preg_replace('/[^a-z_\.]/i','',$function);
		if (!empty($args)) {
			foreach ($args as $varname => $value) {
				$uri .= '&' . $varname . '=' . urlencode($value);
			}
		}
		$this->debug('[REST API] URI: ' . $uri);
		return $this->fetch($uri,$method,array(),'xml');
	}
	
	public function query($query) {
		$response = $this->restapi('fql.query','GET',array('query' => $query));
		if (isset($response['fql_query_response'])) {
			return $response['fql_query_response'];
		} else {
			return null;
		}
	}
	
	protected function parse_response($raw,$mode) {
		if ($mode == 'fb_json') {
			$response = OAuthHelper::parse_json($raw);
			
			if (isset($response['data'])) {
				$data = $response['data'];
				unset($response);
			} else {
				$data =& $response;
			}
			
			foreach (array_keys($data) as $key) {
				if (!is_array($data[$key])) continue;
				$type = false;
				$has = array();
				//album
				if (strpos($data[$key]['link'],'album.php') !== false) {
					$type = 'album';
					$has = array('photos' => 'photo','comments' => 'comment');
				}
				//event
				else if (isset($data[$key]['start_time']) AND isset($data[$key]['venue'])) {
					$type = 'event';
					$has = array('feed' => 'post','picture' => 'picture',
						'noreply' => 'user','maybe' => 'user','invited' => 'user','attending' => 'user','declined' => 'user'
					);
				}
				//group
				else if (isset($data[$key]['venue'])) {
					$type = 'group';
					$has = array('feed' => 'post','members' => 'user','picture' => 'picture');
				}
				//message
				else if (isset($data[$key]['to']) AND isset($data[$key]['message'])) {
					$type = 'message';
					$has = array('comments' => 'comment');
				}
				//note
				else if (isset($data[$key]['subject']) AND isset($data[$key]['message'])) {
					$type = 'note';
					$has = array('comments' => 'comment');
				}
				//page
				else if (isset($data[$key]['category'])) {
					$type = 'page';
					$has = array(
						'feed' => 'post','picture' => 'picture','tagged' => 'post',
						'links' => 'post', 'photos' => 'photo', 'groups' => 'group', 'albums' => 'album',
						'statuses' => 'post', 'videos' => 'video', 'notes' => 'note', 'posts' => 'post', 
						'events' => 'event'
					);
				}
				//photo
				else if (isset($data[$key]['picture'])) {
					$type = 'photo';
					$has = array('comments' => 'comment');
				}
				//user
				else if (isset($data[$key]['first_name']) AND isset($data[$key]['last_name'])) {
					$type = 'user';
					$has = array(
						'home' => 'post', 'feed' => 'post', 'tagged' => 'post', 'posts' => 'post',
						'picture' => 'picture',
						'friends' => 'user',
						'activities' => 'page', 'interests' => 'page', 'music' => 'page', 'books' => 'page',
						'movies' => 'page', 'television' => 'page', 'likes' => 'page',
						'photos' => 'photo', 'albums' => 'album', 'videos' => 'video',
						'groups' => 'group', 'statuses' => 'post', 'links' => 'post',
						'notes' => 'note', 'events' => 'event',
						'inbox' => 'message', 'outbox' => 'message', 'updates' => 'message',
					);
				}
				//video
				else if (isset($data[$key]['length'])) {
					$type = 'video';
					$has = array('comments' => 'comment');
				}
				//post 
				else if (isset($data[$key]['from'])) {
					//maybe a post
					$type = 'post';
					$has = array('comments' => 'comment');
				}
			}

			return $data;
		} else {
			return parent::parse_response($raw,$mode);
		}
	}
	
	public static function scopes($perm_filter) {
		$scopes = array(
			'publish_stream' => OAUTH_PERMISSION_WRITE,
			'create_event' => OAUTH_PERMISSION_WRITE,
			'rsvp_event' => OAUTH_PERMISSION_WRITE,
			'sms' => OAUTH_PERMISSION_WRITE,
			'offline_access' => OAUTH_PERMISSION_WRITE,
			'manage_pages' => OAUTH_PERMISSION_WRITE,
			
			'email' => OAUTH_PERMISSION_READ	,
			'read_stream' => OAUTH_PERMISSION_READ,
			'user_about_me' => OAUTH_PERMISSION_READ,
			'user_activities' => OAUTH_PERMISSION_READ,
			'user_birthday' => OAUTH_PERMISSION_READ,
			'user_education_history' => OAUTH_PERMISSION_READ,
			'user_events' => OAUTH_PERMISSION_READ,
			'user_groups' => OAUTH_PERMISSION_READ,
			'user_hometown' => OAUTH_PERMISSION_READ,
			'user_interests' => OAUTH_PERMISSION_READ,
			'user_likes' => OAUTH_PERMISSION_READ,
			'user_location' => OAUTH_PERMISSION_READ,
			'user_notes' => OAUTH_PERMISSION_READ,
			'user_online_presence' => OAUTH_PERMISSION_READ,
			'user_photo_video_tags' => OAUTH_PERMISSION_READ,
			'user_photos' => OAUTH_PERMISSION_READ,
			'user_relationships' => OAUTH_PERMISSION_READ,
			'user_religion_politics' => OAUTH_PERMISSION_READ,
			'user_status' => OAUTH_PERMISSION_READ,
			'user_videos' => OAUTH_PERMISSION_READ,
			'user_website' => OAUTH_PERMISSION_READ,
			'user_work_history' => OAUTH_PERMISSION_READ,
			'read_friendlists' => OAUTH_PERMISSION_READ,
			'read_requests' => OAUTH_PERMISSION_READ,
			'read_mailbox' => OAUTH_PERMISSION_READ,
		);
		
		$return = array();
		foreach ($scopes as $scope => $perm) {
			if ($perm & $perm_filter) {
				$return[] = $scope;
			}
		}
		return implode(',',$return);
	}
}
?>