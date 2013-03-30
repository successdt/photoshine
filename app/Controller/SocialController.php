<?php
/**
 * social share controller
 * @author thanhdd@lifetimetech.vn
 */
App::import('Controller', 'Api');
App::uses('AppController', 'Controller');
App::uses('HttpSocket', 'Network/Http');
App::uses('Facebook', 'Lib/Facebook');
App::uses('Weibo', 'Lib/Weibo');
App::uses('Flickr', 'Lib/Flickr');
class SocialController extends AppController {
	var $components = array('OAuthConsumer');


	public function beforeFilter() {
		parent::beforeFilter();
	}

	public function postPhoto(){
		set_time_limit(60);
		$this->autoRender = false;
		$facebookConfig = Configure::read('Facebook.config');;
		$flickrConfig = Configure::read('Flickr.config');
		$data = $this->request->data;
		$this->autoRender = false;
		$tmpDir = $this->webroot. 'app/webroot/' . IMG_TEMP_DIR;
		$photoUrl = $data['photoUrl'];
		$photoId = $data['photoId'];
		$caption = $data['caption'];
		
		$uploadFailed = array(
			'token_expired' => array(),
			'upload_error' => array()
		);
		$errorCode = array(
			'facebook' => array(190, 102, 2500),
			'twitter' => array(34, 89, 215, 32),
			'tumblr' => array(401),
			'flickr' => array(96, 97, 98)
		);
		
		$user = $this->Auth->user();
		$data['userId'] = '';
		if (isset($user['User']['id']))
			$data['userId'] = $user['User']['id'];
		$Api = new ApiController;
		$response = $Api->getSocialToken($data);							
		$token = $response['data'];
		
		//save image to local disk		
		$imageString = file_get_contents($photoUrl);
		$tmp = WWW_ROOT . str_replace('/', DS, IMG_TEMP_DIR) . $photoId . '.jpg';
		$img = imagecreatefromstring($imageString); 
		imagejpeg($img, $tmp); 
		unset($img);
		$imagePath = '@' . realpath('img/upload/tmp/' . $photoId . '.jpg');
		

		if ($data['facebook'] == 'true'){
			$Facebook = new Facebook($facebookConfig);
			$Facebook->setAccessToken($token['facebook_token']);
			$Facebook->setFileUploadSupport(true);
			$facebookArgs = array(
				'image' => $imagePath,
				'message' => $caption
			);
			
			$response = $Facebook->api('/me/photos','post',$facebookArgs);
			if (!isset($response['id']) || !$response['id']){
				array_push($uploadFailed['upload_error'], 'Facebook');
				
				if(in_array($response['code'], $errorCode['facebook'])){
					array_push($uploadFailed['token_expired'], 'fb');
				}
			}
		}


		if ($data['twitter'] == 'true'){
			$twitterArgs = array(
				'status' => $caption
			);
			
			$response = $this->OAuthConsumer->postMultipartFormData(
				'Twitter',
				$token['twitter_token'],
				$token['twitter_secret'],
				'https://api.twitter.com/1.1/statuses/update_with_media.json',
				array('media[]' => realpath('img/upload/tmp/' . $photoId . '.jpg')),
				$twitterArgs
			);
			
			
			$response = json_decode($response, true);

			if (!isset($response['id']) || !$response['id']){
				array_push($uploadFailed['upload_error'], 'Twitter');
				
				if(in_array($response['errors'][0]['code'], $errorCode['twitter'])){
					array_push($uploadFailed['token_expired'], 'tw');
				}
			}
		}
		
		
		if ($data['tumblr'] == 'true'){
			$tumblrArgs = array(
				'type' => 'photo',
				'caption' => $caption,
				'source' => $photoUrl
			);
			$blogName = explode('//',$token['tumblr_id']);
			
			$response = $this->OAuthConsumer->post(
				'Tumblr',
				$token['tumblr_token'],
				$token['tumblr_secret'],
				'http://api.tumblr.com/v2/blog/' . $blogName[1] .'post',
				$tumblrArgs
			);
			$response = json_decode($response, true);

			if (!isset($response['response']['id']) || !$response['response']['id']){
				array_push($uploadFailed['upload_error'], 'Tumblr');
				
				if(in_array($response['meta']['status'], $errorCode['tumblr'])){
					array_push($uploadFailed['token_expired'], 'tm');
				}
			}						
		}
		
		if ($data['flickr'] == 'true'){
			$Flickr = new Flickr($flickrConfig['appKey'], $flickrConfig['appSecret']);
		
			$Flickr->setToken($token['flickr_token']);
			$response = $Flickr->async_upload($imagePath, '',$caption);
			
			if (isset($response['error'])){
				array_push($uploadFailed['upload_error'], 'Flickr');
				
				if(in_array($response['error']['code'], $errorCode['flickr'])){
					array_push($uploadFailed['token_expired'], 'fr');
				}
			}
		}

		echo json_encode($uploadFailed);
		unlink($tmp);		
	}
	
	
	/**
	 * redirect to other social
	 * @author thanhdd@lifetimetech.vn
	 * @param name
	 * 
	 */
	public function auth($name = null){
		
		$facebookConfig = Configure::read('Facebook.config');
		$flickrConfig = Configure::read('Flickr.config');
		$callbackUrl = 'http://' . $_SERVER['SERVER_NAME'] . Router::url(array(
			'controller' => 'social',
			'action' => 'callback',
			$name			
		));
		$this->autoRender = false;
		
		
		switch($name){
			
			case 'facebook': 
				$Facebook = new Facebook($facebookConfig);
				$loginUrl = $Facebook->getLoginUrl(
					array(
						'scope' => 'publish_stream read_friendlists',
						'redirect_uri' => $callbackUrl
					)
				);
				break;
				
			case 'twitter':
				$twitterRequestToken = $this->OAuthConsumer->getRequestToken(
					'Twitter',
					'https://api.twitter.com/oauth/request_token',
					$callbackUrl
				);
				$this->Session->write('twitter_request_token', $twitterRequestToken);			
				if ($twitterRequestToken){
					$loginUrl = 'https://api.twitter.com/oauth/authorize?oauth_token=' . $twitterRequestToken->key;
				}
				break;
				
			case 'tumblr':
				$tumblrRequestToken = $this->OAuthConsumer->getRequestToken(
					'Tumblr',
					'http://www.tumblr.com/oauth/request_token',
					$callbackUrl
				);
				$this->Session->write('tumblr_request_token', $tumblrRequestToken);
				if ($tumblrRequestToken)
					$loginUrl = 'http://www.tumblr.com/oauth/authorize?oauth_token=' . $tumblrRequestToken->key;
				break;
				
			case 'flickr':
				$Flick = new Flickr($flickrConfig['appKey'], $flickrConfig['appSecret']);
				$loginUrl = $Flick->auth('write');
				break;
				
			default:
				$this->set('isError', true);
					
		}
		if(isset($loginUrl))
			$this->redirect($loginUrl);	
		
		
	}
	
	/**
	 * get token and secret when callback
	 * @author thanhdd@lifetimetech.vn
	 * @param name
	 * 
	 */	
	public function callback($name = null)
	{
		$facebookConfig = Configure::read('Facebook.config');
		$flickrConfig = Configure::read('Flickr.config');
		
		$Api = new ApiController();
		$userInfo = $this->Auth->user();
		$id = $userInfo['User']['id'];
		
		$isSuccess = true;
		
		switch($name){
			
			case 'facebook': 
				$Facebook = new Facebook($facebookConfig);
				$accessToken = $Facebook->getAccessToken();
				$response = $Facebook->api('/me','get','');;
				$args = array(
					'facebook_id' => $response['id'],
					'facebook_token' => $accessToken
				);
				break;
				
			case 'twitter':
				$requestToken = $this->Session->read('twitter_request_token');        
				$accessToken = $this->OAuthConsumer->getAccessToken('Twitter', 'https://api.twitter.com/oauth/access_token', $requestToken);
				$response = $this->OAuthConsumer->get(
					'Twitter', 
					$accessToken->key, 
					$accessToken->secret, 
					'https://api.twitter.com/1.1/account/verify_credentials.json'
				);
				$response = json_decode($response, true);
				$args = array(
					'twitter_id' => $response['id'],
					'twitter_token' => $accessToken->key,
					'twitter_secret' => $accessToken->secret
				);
				break;
				
			case 'tumblr':
				$requestToken = $this->Session->read('tumblr_request_token');        
				$accessToken = $this->OAuthConsumer->getAccessToken('Tumblr', 'http://www.tumblr.com/oauth/access_token', $requestToken);
				$response = $this->OAuthConsumer->get(
					'Tumblr', 
					$accessToken->key, 
					$accessToken->secret, 
					'http://api.tumblr.com/v2/user/info'
				);
				$response = json_decode($response, true);
				
				$args = array(
					'tumblr_id' => $response['response']['user']['blogs'][0]['url'],
					'tumblr_token' => $accessToken->key,
					'tumblr_secret' => $accessToken->secret
				);
				break;
				
			case 'flickr':
				$Flick = new Flickr($flickrConfig['appKey'], $flickrConfig['appSecret']);
			
				$accessToken = $Flick->auth_getToken($_GET['frob']);
				$args = array(
					'flickr_id' => $accessToken['user']['nsid'],
					'flickr_token' => $accessToken['token']
				);	
				break;
			default:
				$isSuccess = false;
					
		}
		if ($isSuccess){
			$response = $Api->updateYourData($args, $id);
		}
		if (isset($response['meta']['success']) && $response['meta']['success']){
			$isSuccess = true;
		}
		else {
			$isSuccess = false;
		}
		
		$this->set(compact('isSuccess', 'name'));
		$this->layout = "popup";
	}
	/*
	public function test(){
		$this->autoRender = false;
		$facebookConfig = Configure::read('Facebook.config');
		$Facebook = new Facebook($facebookConfig);
		$Api = new ApiController;
		$user = $this->Auth->user();
		$data['userId'] = '';
		if (isset($user['User']['id']))
			$data['userId'] = $user['User']['id'];
		$response = $Api->getSocialToken($data);							
		$token = $response['data'];
		$Facebook->setAccessToken($token['facebook_token']);
		$facebookArgs = array(
			'tags' => '100000270981562',
			'message' => 'Này thì test tag friend này',
			'place' => '454604644608832'
		);
		
		$response = $Facebook->api('/me/feed','post',$facebookArgs);
		debug($response);	
	}
	*/
}