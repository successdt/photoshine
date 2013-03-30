<?php
/**
 * @author thanhdd@lifetimetech.vn
 */
class ApiController extends AppController {
	public $uses = array('User', 'Photo', 'Location', 'Follow');

	public function beforeFilter() {
		parent::beforeFilter();
		$this->autoRender = false;
		$this->Auth->allow(array('registerUser', 'checkUser', 'login'));

	}
	
	/**
	 * register new user
	 */
	public function registerUser($userInfo = null){
		$return = array(
			'meta' => array(
				'success' => false,
				'error_message' => ''
			),
			'data' => array()
		);
		$emailReg = '/^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/';
		$userReg = '/^[\w\.@]{6,50}$/';
		
		if (!$userInfo){
			$return['meta']['error_message'] = 'Non object userInfo';
			return $return;
		}
		
		if ((!isset($userInfo['username'])) || (!$userInfo['username'])){
			$return['meta']['error_message'] = 'Empty username';
			return $return;
		}
		
		if ((!isset($userInfo['email'])) || (!$userInfo['email'])){
			$return['meta']['error_message'] = 'Empty email';
			return $return;
		}
		if ((!isset($userInfo['password'])) || (!$userInfo['password'])){
			$return['meta']['error_message'] = 'Empty password';
			return $return;
		}
		//check validation
		if (!preg_match($userReg, $userInfo['username'])){
			$return['meta']['error_message'] = 'Invalid username format';
			return $return;			
		}		
		if (!preg_match($emailReg, $userInfo['email'])){
			$return['meta']['error_message'] = 'Invalid email format';
			return $return;			
		}
		if (strlen($userInfo['password']) < 6 || strlen($userInfo['password']) > 16){
			$return['meta']['error_message'] = 'Password must be 6-16 characters';
			return $return;				
		}
		$checkName = $this->checkUser($userInfo);
		if ($checkName['data']['exiting']){
			$return['meta']['error_message'] = 'Username is already in used';
			return $return;				
		}
		$userInfo['profile_picture'] =  'profile/default_avatar.png';
		$userInfo['password'] = md5($userInfo['password']);
		$userInfo['username'] = strtolower($userInfo['username']);
		$userInfo['first_name'] = '';
		$userInfo['last_name'] = '';
		$result = $this->User->save($userInfo);
		if($result['User']['id']){
			$return['meta']['success'] = true;
			$return['data'] = $result;
		}
			
		return $return;
	}
	
	/**
	 * check user exiting
	 */
	public function checkUser($data){
		$return = array(
			'meta' => array(
				'success' => false,
				'error_message' => ''
			),
			'data' => array('exiting' => false)
		);
		
		if (!$data['username']){
			$return['meta']['error_message'] = 'Empty username';
			return $return;
		}
		$result = $this->User->find('count', array('conditions' => array('username' => strtolower($data['username']))));
		if ($result){
			$return['data']['exiting'] = true;		
		}
		$return['meta']['success'] = true;
		return $return;
	}
	
	/**
	 * login
	 */
	 
	public function login($userInfo){
		$return = array(
			'meta' => array(
				'success' => false,
				'error_message' => ''
			),
			'data' => array('status' => '')
		);
		
		$userReg = '/^[\w\.@]{6,50}$/';
		
		if ((!isset($userInfo['username'])) || (!$userInfo['username'])){
			$return['meta']['error_message'] = 'Empty username';
			return $return;
		}
		
		if ((!isset($userInfo['password'])) || (!$userInfo['password'])){
			$return['meta']['error_message'] = 'Empty password';
			return $return;
		}
		
		//check validation
		if (!preg_match($userReg, $userInfo['username'])){
			$return['meta']['error_message'] = 'Invalid username format';
			return $return;			
		}
		
		if (strlen($userInfo['password']) < 6 || strlen($userInfo['password']) > 16){
			$return['meta']['error_message'] = 'Password must be 6-16 characters';
			return $return;				
		}
		$userInfo['password'] = md5($userInfo['password']);
		
		$result = $this->User->find('first', array('conditions' => array('username' => strtolower($userInfo['username']))));
		if (!$result){
			$return['data']['status'] = 'Username does not exist';
			return $return;
		}
		$result = $this->User->find('first', array('conditions' => $userInfo));
		if ($result){
			$return['data'] = $result;
			$return['data']['status'] = 'ok';		
		}
		else {
			$return['data']['status'] = 'Invalid password';
		}
		$return['meta']['success'] = true;	
		
		return $return;
	}
	
	/**
	 * post photo
	 */
	public function postPhoto($data){
		$return = array(
			'meta' => array(
				'success' => false,
				'error_message' => ''
			),
			'data' => array('id' => '')
		);
		$output = 'http://' . $_SERVER['SERVER_NAME'] . Router::url(array('controller' => 'img', 'action' => 'upload')) . '/' ;

		$this->Photo->save($data);
		$return['data']['id'] = $this->Photo->getInsertID();
		$return['meta']['success'] = true;
		
		$id = $return['data']['id'];
		$this->Photo->id = $id;
		$newData = array(
			'standard_resolution' => $output . $id . '.jpg',
			'thumbnail' => $output . $id . '_thumb.jpg',
			'low_resolution_url' => $output . $id . '_low.jpg'
		);
		$this->Photo->save($newData);
		return $return;
	}
	
	/**
	 * update photo infomation
	 */
	public function updatePhoto($data, $userId = null){
		$return = array(
			'meta' => array(
				'success' => false,
				'error_message' => ''
			),
			'data' => array('id' => '')
		);
		if (!isset($data['photoId']) && $data['photoId']){
			$return['meta']['error_message'] = 'Empty photo id';
			return $return;
		}
		
		$photoId = $data['photoId'];
		unset($data['photoId']);
		
		foreach ($data as $key => $value){
			$data[$key] = "'" . $value . "'";
		}
		
		$this->Photo->updateAll($data, array(
			'user_id' => $userId,
			'id' => $photoId
		));
		$return['meta']['success'] = true;
		
		return $return;
	}
	
	/**
	 * add new location
	 */
	public function addLocation($data){
		$return = array(
			'meta' => array(
				'success' => false,
				'error_message' => ''
			),
			'data' => array('id' => '')
		);
		
		$response = $this->Location->find('first', array('conditions' => array('facebook_id' => $data['facebook_id'])));
	
		if(isset($response['Location']['id']) && $response['Location']['id']){
			$return['meta']['success'] = true;
			$return['data']['id'] = $response['Location']['id'];
		}
		else {
			$this->Location->save($data);
			$return['meta']['success'] = true;
			$return['data']['id'] = $this->Location->getInsertID();
		}
		return $return;			
	}
	
	/**
	 * update user info
	 */
	public function updateYourData($data, $userId = null){
		$return = array(
			'meta' => array(
				'success' => false,
				'error_message' => ''
			),
			'data' => array('id' => '')
		);
		$notAllowed = array('id', 'username', 'report');
		
		if (!isset($userId) && $userId){
			$return['meta']['error_message'] = 'Empty user id';
			return $return;
		}
		
		foreach ($notAllowed as $field){
			if (isset($data[$field]))
				unset($data[$field]);
		}
		$this->User->id = $userId;
		$this->User->save($data);
		$return['meta']['success'] = true;
		
		return $return;						
	}
	
	/**
	 * get all social token of user
	 */
	public function getSocialToken($data, $userId = null){ 
		$return = array(
			'meta' => array(
				'success' => false,
				'error_message' => ''
			),
			'data' => array()
		);

		if (!isset($userId) && $userId){
			$return['meta']['error_message'] = 'Empty user id';
			return $return;
		}
		$result = $this->User->find('first', array(
			'conditions' => array('id' => $data['userId']),
			'fields' => array('facebook_id', 'facebook_token', 'twitter_id', 'twitter_token', 'twitter_secret',
				'tumblr_id', 'tumblr_token', 'tumblr_secret', 'flickr_id', 'flickr_token')	
		));
		if ($result && isset($result['User']))
			$return['meta']['success'] = true;
		$return['data'] = $result['User'];
		return $return;
	}
	
	/**
	 * get Your profile from db
	 */
	public function getYourData($data, $userId = null){
		$return = array(
			'meta' => array(
				'success' => false,
				'error_message' => ''
			),
			'data' => array()
		);
		if (!$userId){
			$return['meta']['error_message'] = 'Empty user id';
			return $return;
		}
		$result = $this->User->find('first', array('conditions' => array('id' => $userId)));
		if ($result && isset($result['User']))
			$return['meta']['success'] = true;
		$return['data'] = $result['User'];
		return $return;		
	}
	
	/**
	 * change your password
	 */
	public function changeYourPassword($data, $userId = null){
		$return = array(
			'meta' => array(
				'success' => false,
				'error_message' => ''
			),
			'data' => array()
		);
		if (!isset($data['old_password']) || !$data['old_password'] || !isset($data['password']) || !$data['password']){
			$return['meta']['error_message'] = 'Empty user id';
			return $return;
		}
		if (strlen($data['password']) < 6 || strlen($data['password']) > 16){
			$return['meta']['error_message'] = 'Password must be 6-16 characters';
			return $return;				
		}
		$update = array('password' => md5($data['password']));
		$user = $this->User->find('first', array(
			'conditions' => array(
				'id' => $userId,
				'password' => md5($data['old_password'])
				)
			));
		if (isset($user['User'])){
			$this->User->id = $userId;
			$this->User->save($update);
			$return['meta']['success'] = true;
		}
		else {
			$return['error_message'] = 'Invalid password!';
		}
		return $return;
	}
	/**
	 * find friend from other service
	 *
	 */
	public function findFriendFromOtherServices($data, $userId = null){
		$return = array(
			'meta' => array(
				'success' => false,
				'error_message' => ''
			),
			'data' => array()
		);
		$snsName = array('facebook', 'twitter');
		if (!in_array($data['type'], $snsName)){
			$return['meta']['error_message'] = 'Invalid service name';
			return $return;			
		}
		
		if (!isset($data['ids']) || !$data['ids']){
			$return['meta']['error_message'] = 'Empty list';
			return $return;					
		}
		$listSns = explode(',',$data['ids']);
		$conditions = array();
		$result = $this->User->find('all', array(
			'conditions' => array($data['type'] . '_id' => $listSns),
			'fields' => array('id', 'first_name', 'last_name', 'profile_picture', 'username')
		));
		if ($result){
			$i = 0;
			$listFollower = $this->getListFollowerId($data, $userId);
			foreach ($result as $user){
				if (in_array($user['User']['id'], $listFollower)){
					$result[$i]['User']['following'] = 1;
				}
				else {
					$result[$i]['User']['following'] = 0;
				}
				$i++;
			}
		}
		$return['meta']['success'] = true;
		$return['data'] = $result;
		return $return;
		
	}
	/**
	 * 
	 */
	public function getListFollowerId($data, $userId = null){
		$listFollowers = array();
		$yourFollowers = $this->Follow->find('all', array(
			'conditions' => array(
				'user_had_accepted' => '1',
				'OR' => array(
					'from_user_id' => $userId,
					'to_user_id' => $userId
				)
			)
		));
		foreach($yourFollowers as $follow){
			array_push($listFollowers, $follow['Follow']['from_user_id']);
			array_push($listFollowers, $follow['Follow']['to_user_id']);
		}
		return $listFollowers;
	}
	
	/**
	 * remove your connection to other socials
	 */
	public function removeServices($data, $userId = null){
		$return = array(
			'meta' => array(
				'success' => false,
				'error_message' => ''
			),
			'data' => array('id' => '')
		);
		$notAllowed = array('id', 'username', 'report');
		
		if (!isset($data['type']) && $data['type']){
			$return['meta']['error_message'] = 'Empty type name';
			return $return;
		}
		if ($data['type'] == 'facebook' || $data['type'] == 'flickr'){
			$params = array(
				$data['type'] . '_id' => '',
				$data['type'] . '_token' => ''
			);
		}
		else{
			$params = array(
				$data['type'] . '_id' => '',
				$data['type'] . '_token' => '',
				$data['type'] . '_secret' => ''
			);			
		}
		$this->User->id = $userId;
		$this->User->save($params);
		$return['meta']['success'] = true;
		
		return $return;						
	}
	
	/**
	 * follow user
	 */
	public function followUser($data, $userId = null){
		$return = array(
			'meta' => array(
				'success' => false,
				'error_message' => ''
			),
			'data' => array()
		);
		if (!isset($data['id']) && $data['id']){
			$return['meta']['error_message'] = 'Empty user id';
			return $return;
		}
		$params = array(
			'from_user_id' => $userId,
			'to_user_id' => $data['id'],
			'user_had_accepted' => 0
		);
		$this->Follow->save($params);
		$return['meta']['success'] = true;
		
		return $return;		
	}
	
	/**
	 * unfollow user
	 */
	public function unfollowUser($data, $userId = null){
		$return = array(
			'meta' => array(
				'success' => false,
				'error_message' => ''
			),
			'data' => array()
		);
		if (!isset($data['id']) && $data['id']){
			$return['meta']['error_message'] = 'Empty user id';
			return $return;
		}
		$params = array(
			'OR' => array(
				array(
					'from_user_id' => $userId,
					'to_user_id' => $data['id']				
				),
				array(
					'to_user_id' => $userId,
					'from_user_id' => $data['id']					
				)
			)
		);
		$this->Follow->deleteAll($params);
		$return['meta']['success'] = true;
		
		return $return;		
	}
	
	/**
	 * get photo detail
	 */
	public function getPhotoDetail($data, $userId = null){
		$return = array(
			'meta' => array(
				'success' => false,
				'error_message' => ''
			),
			'data' => array()
		);
		if (!isset($data['id']) && $data['id']){
			$return['meta']['error_message'] = 'Empty photo id';
			return $return;
		}
		$result = $this->Photo->find('first', array(
			'joins' => array(
				array(
					'table' => 'likes',
					'type' => 'LEFT',
					'conditions' => array(
						'photos.id = likes.photo_id'
					)
				),
				array(
					'table' => 'comments',
					'type' => 'LEFT',
					'conditions' => array(
						'photos.id = comments.photo_id'
					)				
				),
				array(
					'table' => 'locations',
					'type' => 'LEFT',
					'conditions' => array(
						'photos.location_id = locations.id'
					)				
				)
			),
			'conditions' => array(
				'id' => $data['id']
			)
		));
		debug($this->Photo->getLastQueries());
		debug($result);
		die;
	}
	
}