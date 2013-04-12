<?php
/**
 * @author thanhdd@lifetimetech.vn
 */
class ApiController extends AppController {
	public $uses = array('User', 'Photo', 'Location', 'Follow', 'Like', 'Comment');

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
			unset($userInfo['password']);
			$return['data']['User'] = $userInfo;
			$return['data']['User']['id'] = $result['User']['id'];
			$return['data']['status'] = 'ok';
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
//		$output = 'http://' . $_SERVER['SERVER_NAME'] . Router::url(array('controller' => 'img', 'action' => 'upload')) . '/' ;
		$output = 'upload/';

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
		if (!isset($data['photoId']) || !$data['photoId']){
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
		
		if (!isset($userId) || !$userId){
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

		if (!isset($userId) || !$userId){
			$return['meta']['error_message'] = 'Empty user id';
			return $return;
		}
		$result = $this->User->find('first', array(
			'conditions' => array('id' => $userId),
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
				'from_user_id' => $userId,
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
		
		if (!isset($data['type']) || !$data['type']){
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
		if (!isset($data['id']) || !$data['id']){
			$return['meta']['error_message'] = 'Empty user id';
			return $return;
		}
		$params = array(
			'from_user_id' => $userId,
			'to_user_id' => $data['id'],
			'user_had_accepted' => 1 //muốn confirm thì sửa cái này
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
		if (!isset($data['id']) || !$data['id']){
			$return['meta']['error_message'] = 'Empty user id';
			return $return;
		}
		$params = array(
			array(
				'from_user_id' => $userId,
				'to_user_id' => $data['id']				
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
		if (!isset($data['id']) || !$data['id']){
			$return['meta']['error_message'] = 'Empty photo id';
			return $return;
		}
		$photo = $this->Photo->find('first', array(
			'conditions' => array(
				'Photo.id' => $data['id']
			),
			'joins' => array(
				array(
					'table' => 'locations',
					'alias' => 'Location',
					'type' => 'LEFT',
					'conditions' => array(
						'Photo.location_id = Location.id'
					)
				),
				array(
					'table' => 'users',
					'alias' => 'User',
					'type' => 'LEFT',
					'conditions' => array(
						'Photo.user_id = User.id'
					)
				)
			),
			'fields' => array('Photo.*', 'Location.*', 'User.id', 'User.username', 'User.profile_picture')
		));
		$like = $this->Like->find('all', array(
			'conditions' => array('photo_id' => $data['id']),
			'joins' => array(
				array(
					'table' => 'users',
					'alias' => 'User',
					'type' => 'LEFT',
					'conditions' => array(
						'Like.user_id = User.id'
					)
				)
			),
			'fields' => array('Like.id', 'Like.created_time', 'User.id', 'User.username', 'User.profile_picture')
		));
		$comment = $this->Comment->find('all', array(
			'conditions' => array('photo_id' => $data['id']),
			'joins' => array(
				array(
					'table' => 'users',
					'alias' => 'User',
					'type' => 'LEFT',
					'conditions' => array(
						'Comment.user_id = User.id'
					)
				)
			),
			'fields' => array('Comment.id', 'Comment.created_time', 'Comment.text', 'User.id', 'User.username', 'User.profile_picture'),
			'order' => array('Comment.created_time DESC'),
			'limit' => 5
		));
		$comment = array_reverse($comment, true);
		$commentCount = $this->Comment->find('count', array(
			'conditions' => array('photo_id' => $data['id']),
		));
		$liked = false;
		foreach ($like as $eachLike){
			if ($eachLike['User']['id'] == $userId){
				$liked = true;
			}
		}
		
		$return['data']['Photo'] = $photo['Photo'];
		$return['data']['Photo']['User'] = $photo['User'];
		$return['data']['Photo']['Location'] = $photo['Location'];
		$return['data']['Comment'] = $comment;
		$return['data']['Like'] = $like;
		$return['data']['comment_count'] = $commentCount;
		$return['data']['Photo']['user_had_liked'] = $liked;
		return $return;
	}
	
	/**
	 * like a photo
	 */
	public function likePhoto($data, $userId = null){
		$return = array(
			'meta' => array(
				'success' => false,
				'error_message' => ''
			),
			'data' => array()
		);
		if (!isset($data['id']) || !$data['id']){
			$return['meta']['error_message'] = 'Empty photo id';
			return $return;
		}
		$params = array(
			'user_id' => $userId,
			'photo_id' => $data['id']
		);
		$liked = $this->Like->find('first', array('conditions' => $params));
		if (isset($liked['Like']['id'])){
			$return['meta']['error_message'] = 'You had liked this photo';
			return $return;			
		}
		$this->Like->save($params);
		$return['meta']['status'] = true;
		
		return $return;
	}
	/**
	 * unlike a photo
	 */
	public function unlikePhoto($data, $userId = null){
		$return = array(
			'meta' => array(
				'success' => false,
				'error_message' => ''
			),
			'data' => array()
		);
		if (!isset($data['id']) || !$data['id']){
			$return['meta']['error_message'] = 'Empty photo id';
			return $return;
		}
		$params = array(
			'user_id' => $userId,
			'photo_id' => $data['id']
		);
		$this->Like->deleteAll($params);
		$return['meta']['status'] = true;
		
		return $return;
	}
	/**
	 * post a comment
	 */
	public function postComment($data, $userId = null){
		$return = array(
			'meta' => array(
				'success' => false,
				'error_message' => ''
			),
			'data' => array()
		);
		if (!isset($data['photo_id']) || !$data['photo_id']){
			$return['meta']['error_message'] = 'Empty photo id';
			return $return;
		}
		if (!isset($data['text']) || !$data['text']){
			$return['meta']['error_message'] = 'Empty comment';
			return $return;
		}
		$data['user_id'] = $userId;
		$this->Comment->save($data);
		$return['meta']['status'] = true;
		
		return $return;		
	}
	
	/**
	 * get all comment of a photo
	 */
	public function getCommentOfPhoto($data, $userId = null){
		$return = array(
			'meta' => array(
				'success' => false,
				'error_message' => ''
			),
			'data' => array()
		);
		if (!isset($data['id']) || !$data['id']){
			$return['meta']['error_message'] = 'Empty photo id';
			return $return;
		}
		$comment = $this->Comment->find('all', array(
			'conditions' => array('photo_id' => $data['id']),
			'joins' => array(
				array(
					'table' => 'users',
					'alias' => 'User',
					'type' => 'LEFT',
					'conditions' => array(
						'Comment.user_id = User.id'
					)
				)
			),
			'fields' => array('Comment.id', 'Comment.created_time', 'Comment.text', 'User.id', 'User.username', 'User.profile_picture'),
		));
		
		$return['meta']['status'] = true;
		$return['data'] = $comment;
		return $return;		
	}
	/**
	 * get list photo for channel
	 */
	public function getListPhotoByChannel($data, $userId = null){
		$itemsPerPage = 20;
		$return = array(
			'meta' => array(
				'success' => false,
				'error_message' => ''
			),
			'data' => array()
		);
		if (!isset($data['tag']) || !$data['tag']){
			$return['meta']['error_message'] = 'Empty tag';
			return $return;
		}
		
		if (!isset($data['page']) || !$data['page'] || !($data['page']) || ($data['page'] < 0)){
			$data['page'] = 0;
		}

		$limit = ($itemsPerPage * $data['page']) . "," . $itemsPerPage;
		$photos = $this->Photo->find('all', array(
			'conditions' => array(
				'OR' => array(
					array('Photo.tags LIKE' => '#' . $data['tag'] . ',%'),
					array('Photo.tags LIKE' => '%,#' . $data['tag'])
				)
			),
			'joins' => array(
				array(
					'table' => 'locations',
					'alias' => 'Location',
					'type' => 'LEFT',
					'conditions' => array(
						'Photo.location_id = Location.id'
					)
				),
				array(
					'table' => 'users',
					'alias' => 'User',
					'type' => 'LEFT',
					'conditions' => array(
						'Photo.user_id = User.id'
					)
				)
			),
			'fields' => array('Photo.*', 'Location.*', 'User.id', 'User.username', 'User.profile_picture'),
			'limit' => $limit
		));
		$query = $this->Photo->getLastQueries();

		//next page
		$return['meta']['next_page'] = $data['page'] + 1;
		if (count($photos) < $itemsPerPage){
			$return['meta']['next_page'] = 0;
		}
				
		
		$return['data'] = $this->getListPhoto($photos, $userId);
		return $return;	
	}
	
	/**
	 * get list photo information
	 */
	public function getListPhoto($photos, $userId){
		$return = array();
		$i = 0;
		foreach($photos as $photo){
			$photoId = $photo['Photo']['id'];
			$like = $this->Like->find('all', array(
				'conditions' => array('photo_id' => $photoId),
				'fields' => 'Like.user_id'
			));
			$comment = $this->Comment->find('all', array(
				'conditions' => array('photo_id' => $photoId),
				'joins' => array(
					array(
						'table' => 'users',
						'alias' => 'User',
						'type' => 'LEFT',
						'conditions' => array(
							'Comment.user_id = User.id'
						)
					)
				),
				'fields' => array('Comment.id', 'Comment.created_time', 'Comment.text', 'User.id', 'User.username', 'User.profile_picture'),
				'order' => array('Comment.created_time DESC'),
				'limit' => 5
			));
			$comment = array_reverse($comment, true);
			$commentCount = $this->Comment->find('count', array(
				'conditions' => array('photo_id' => $photoId),
			));
			$liked = false;
			foreach ($like as $eachLike){
				if ($eachLike['Like']['user_id'] == $userId){
					$liked = true;
				}
			}
			$return[$i] = $photo['Photo'];
			$return[$i]['Location'] = $photo['Location'];
			$return[$i]['User'] = $photo['User'];
			$return[$i]['like_count'] = count($like);
			$return[$i]['user_had_liked'] = $liked;
			$return[$i]['Comment'] = $comment;
			$return[$i]['comment_count'] = $commentCount;
			$i++;			
		}
		
		return $return;		
	}
	
	/**
	 * get photos are liked by you
	 */
	public function getYourLiked($data, $userId = null){
		$itemsPerPage = 20;
		$return = array(
			'meta' => array(
				'success' => false,
				'error_message' => ''
			),
			'data' => array()
		);
		if (!isset($userId) || !$userId){
			$return['meta']['error_message'] = 'Empty your id';
			return $return;
		}
		if (!isset($data['page']) || !$data['page'] || !($data['page']) || ($data['page'] < 0)){
			$data['page'] = 0;
		}

		$limit = ($itemsPerPage * $data['page']) . "," . $itemsPerPage;		
		$likes = $this->Like->find('all', array(
			'conditions' => array('Like.user_id' => $userId),
			'joins' => array(
				array(
					'table' => 'photos',
					'alias' => 'Photo',
					'type' => 'LEFT',
					'conditions' => array(
						'Like.photo_id = Photo.id'
					)
				),
				array(
					'table' => 'locations',
					'alias' => 'Location',
					'type' => 'LEFT',
					'conditions' => array(
						'Photo.location_id = Location.id'
					)
				),
				array(
					'table' => 'users',
					'alias' => 'User',
					'type' => 'LEFT',
					'conditions' => array(
						'Photo.user_id = User.id'
					)
				)
			),
			'limit' => $limit,
			'order' => array('Like.created_time' => 'desc'),
			'fields' => array('Photo.*', 'Location.*','User.id', 'User.username', 'User.profile_picture')
		));
		
		$return['meta']['next_page'] = $data['page'] + 1;
		if (count($likes) < $itemsPerPage){
			$return['meta']['next_page'] = 0;
		}
				
		
		$return['data'] = $this->getListPhoto($likes, $userId);
		return $return;	
	}
	
	/**
	 * get Channel extra info
	 */
	public function getChannelExtraInfo($data, $userId = null){
		$return = array(
			'meta' => array(
				'success' => false,
				'error_message' => ''
			),
			'data' => array()
		);
		if (!isset($data['tag']) || !$data['tag']){
			$return['meta']['error_message'] = 'Empty tag';
			return $return;
		}
		$photos = $this->Photo->find('all', array(
			'conditions' => array(
				'OR' => array(
					array('Photo.tags LIKE' => '#' . $data['tag'] . ',%'),
					array('Photo.tags LIKE' => '%,#' . $data['tag'])
				)
			),
			'joins' => array(
				array(
					'table' => 'users',
					'alias' => 'User',
					'type' => 'LEFT',
					'conditions' => array(
						'Photo.user_id = User.id'
					)				
				
				)

			),
			'fields' => array('Photo.id, Photo.thumbnail, User.id')
		));
		
		$photoCount = $this->Photo->find('count', array(
			'conditions' => array(
				'OR' => array(
					array('Photo.tags LIKE' => '#' . $data['tag'] . ',%'),
					array('Photo.tags LIKE' => '%,#' . $data['tag'])
				)
			)
		));
		$userIDArray = array();
		$i = 0;
		foreach ($photos as $photo){
			array_push($userIDArray, $photo['User']['id']);
			
			//chỉ lấy 10 ảnh
			if ($i > 9){
				unset($photos[$i]);
			}
			$i++;
		}
		$userIDArray = array_unique($userIDArray);
		
		$return['meta']['success'] = true;
		$return['data']['user_count'] = count($userIDArray);
		$return['data']['photo_count'] = $photoCount;
		$return['data']['photo'] = $photos;
		
		return $return;
	}
	/**
	 * get popular photos
	 */
	function getPopularPhotos($data, $userId = null){
		$itemsPerPage = 20;
		$return = array(
			'meta' => array(
				'success' => false,
				'error_message' => ''
			),
			'data' => array()
		);
		if (!isset($data['page']) || !$data['page'] || !($data['page']) || ($data['page'] < 0)){
			$data['page'] = 0;
		}

		$limit = ($itemsPerPage * $data['page']) . "," . $itemsPerPage;	
		$photo = $this->Like->find('all', array(
			'joins' => array(
				array(
					'table' => 'photos',
					'alias' => 'Photo',
					'type' => 'LEFT',
					'conditions' => array(
						'Like.photo_id = Photo.id'
					)
				),
				array(
					'table' => 'locations',
					'alias' => 'Location',
					'type' => 'LEFT',
					'conditions' => array(
						'Photo.location_id = Location.id'
					)
				),
				array(
					'table' => 'users',
					'alias' => 'User',
					'type' => 'LEFT',
					'conditions' => array(
						'Photo.user_id = User.id'
					)
				)
			),
			'limit' => $limit,
			'fields' => array('Photo.*', 'Location.*','User.id', 'User.username', 'User.profile_picture'),
			'group' => 'Like.photo_id',
			'order' => 'COUNT(photo_id) DESC'
		));
		
		$return['meta']['next_page'] = $data['page'] + 1;
		if (count($photo) < $itemsPerPage){
			$return['meta']['next_page'] = 0;
		}
				
		
		$return['data'] = $this->getListPhoto($photo, $userId);
		return $return;	
	}
	
	/**
	 * get user information
	 */
	public function getUserInfo($data, $userId = null){
		$return = array(
			'meta' => array(
				'success' => false,
				'error_message' => ''
			),
			'data' => array()
		);
		if (!isset($data['name']) || !$data['name']){
			$return['meta']['error_message'] = 'Empty user name';
			return $return;
		}
		$user = $this->User->find('first', array(
			'conditions' => array('username' => $data['name']),
			'fields' => array(
				'id',
				'username',
				'first_name',
				'last_name',
				'profile_picture',
				'city',
				'country',
				'website',
				'bio'
		)));
		if(!isset($user['User']['id'])){
			$return['meta']['error_message'] = 'User not found';
			return $return;			
		}
		$photos = $this->Photo->find('all', array(
			'conditions' => array(
				'user_id' => $user['User']['id']
			),
			'order' => 'RAND()',
			'fields' => array('Photo.thumbnail')
		));		
		$photoCount = $this->Photo->find('count', array(
			'conditions' => array(
				'user_id' => $user['User']['id']
			)		
		));
		$followers = $this->Follow->find('all', array(
			'conditions' => array(
				'to_user_id' => $user['User']['id'],
				'user_had_accepted' => '1'
			),
			'joins' => array(
				array(
					'table' => 'users',
					'alias' => 'User',
					'type' => 'LEFT',
					'conditions' => array(
						'Follow.from_user_id = User.id'
					)				
				
				)

			),
			'order' => 'RAND()',
			'fields' => array('User.username, User.id, User.profile_picture'),
			'limit' => '0, 2'
		));
		$followerCount = $this->Follow->find('count', array(
			'conditions' => array(
				'to_user_id' => $user['User']['id'],
				'user_had_accepted' => '1'
			)
		));
		$following = $this->Follow->find('all', array(
			'conditions' => array(
				'from_user_id' => $user['User']['id'],
				'user_had_accepted' => '1'
			),
			'joins' => array(
				array(
					'table' => 'users',
					'alias' => 'User',
					'type' => 'LEFT',
					'conditions' => array(
						'Follow.to_user_id = User.id'
					)				
				
				)

			),
			'order' => 'RAND()',
			'fields' => array('User.username, User.id, User.profile_picture'),
			'limit' => '0, 2'
		));
		$followingCount = $this->Follow->find('count', array(
			'conditions' => array(
				'from_user_id' => $user['User']['id'],
				'user_had_accepted' => '1'
			)
		));
		$youFollowing = $this->Follow->find('count', array(
			'conditions' => array(
				'from_user_id' => $userId,
				'to_user_id' => $user['User']['id'],
				'user_had_accepted' => '1'
			)
		));
		
		$return['meta']['success'] = true;
		$return['data']['User'] = $user['User'];
		$return['data']['Photo'] = $photos;
		$return['data']['photo_count'] = $photoCount;
		$return['data']['Follower'] = $followers;
		$return['data']['follower_count'] = $followerCount;
		$return['data']['Following'] = $following;
		$return['data']['following_count'] = $followingCount;
		$return['data']['you_are_following'] = $youFollowing ? true : false;
		
		return $return;
	}
	
	/**
	 * get list photo of user
	 */
	public function getListPhotoOfUser($data, $userId = null){
		$itemsPerPage = 20;
		$return = array(
			'meta' => array(
				'success' => false,
				'error_message' => ''
			),
			'data' => array()
		);
		if (!isset($data['id']) || !$data['id']){
			$return['meta']['error_message'] = 'Empty user id';
			return $return;
		}
		
		if (!isset($data['page']) || !$data['page'] || !($data['page']) || ($data['page'] < 0)){
			$data['page'] = 0;
		}

		$limit = ($itemsPerPage * $data['page']) . "," . $itemsPerPage;
		$photos = $this->Photo->find('all', array(
			'conditions' => array(
				'user_id' => $data['id']
			),
			'joins' => array(
				array(
					'table' => 'locations',
					'alias' => 'Location',
					'type' => 'LEFT',
					'conditions' => array(
						'Photo.location_id = Location.id'
					)
				),
				array(
					'table' => 'users',
					'alias' => 'User',
					'type' => 'LEFT',
					'conditions' => array(
						'Photo.user_id = User.id'
					)
				)
			),
			'fields' => array('Photo.*', 'Location.*', 'User.id', 'User.username', 'User.profile_picture'),
			'limit' => $limit
		));
		$query = $this->Photo->getLastQueries();

		//next page
		$return['meta']['next_page'] = $data['page'] + 1;
		if (count($photos) < $itemsPerPage){
			$return['meta']['next_page'] = 0;
		}
				
		
		$return['data'] = $this->getListPhoto($photos, $userId);
		return $return;	
	}
	
	/**
	 * get location information
	 */
	public function getLocationInfo($data, $userId = null){
		$itemsPerPage = 20;
		$return = array(
			'meta' => array(
				'success' => false,
				'error_message' => ''
			),
			'data' => array()
		);
		if (!isset($data['location']) || !is_array($data['location'])){
			$return['meta']['error_message'] = 'Empty list of location id';
			return $return;
		}

		$locations = $this->Location->find('all', array(
			'conditions' => array(
				'Location.facebook_id' => $data['location']
			),
			'joins' => array(
				array(
					'table' => 'photos',
					'alias' => 'Photo',
					'type' => 'LEFT',
					'conditions' => array(
						'Photo.location_id = Location.id'
					)
				)
			),
			'group' => array('Photo.location_id'),
			'fields' => array('count(Photo.id), Location.id, Location.facebook_id'),
		));
		foreach ($locations as $location){
			$photo = $this->Photo->find('first', array(
				'conditions' => array('location_id' => $location['Location']['id']),
				'order' => 'RAND()',
				'fields' => 'thumbnail'
			));
			$query = $this->Photo->getLastQueries();
			if (isset($photo['Photo']['thumbnail']) && $photo['Photo']['thumbnail']){
				$arr = array(
					'id' => $location['Location']['id'],
					'photo_count' => $location[0]['count(`Photo`.`id`)'],
					'thumbnail' => $photo['Photo']['thumbnail']
				);
				$return['data'][$location['Location']['facebook_id']] = $arr;				
			}

		}
		return $return;	
	}
	
	/**
	 * get list photo by location
	 */
	public function getListPhotoByLocation($data, $userId = null){
		$itemsPerPage = 20;
		$return = array(
			'meta' => array(
				'success' => false,
				'error_message' => ''
			),
			'data' => array()
		);
		if (!isset($data['facebook_id']) || !$data['facebook_id']){
			$return['meta']['error_message'] = 'Empty tag';
			return $return;
		}
		
		if (!isset($data['page']) || !$data['page'] || !($data['page']) || ($data['page'] < 0)){
			$data['page'] = 0;
		}

		$limit = ($itemsPerPage * $data['page']) . "," . $itemsPerPage;
		$photos = $this->Photo->find('all', array(
			'conditions' => array(
				'Location.facebook_id' => $data['facebook_id']
			),
			'joins' => array(
				array(
					'table' => 'locations',
					'alias' => 'Location',
					'type' => 'LEFT',
					'conditions' => array(
						'Photo.location_id = Location.id'
					)
				),
				array(
					'table' => 'users',
					'alias' => 'User',
					'type' => 'LEFT',
					'conditions' => array(
						'Photo.user_id = User.id'
					)
				)
			),
			'fields' => array('Photo.*', 'Location.*', 'User.id', 'User.username', 'User.profile_picture'),
			'limit' => $limit
		));
		
		//next page
		$return['meta']['next_page'] = $data['page'] + 1;
		if (count($photos) < $itemsPerPage){
			$return['meta']['next_page'] = 0;
		}
				
		
		$return['data'] = $this->getListPhoto($photos, $userId);
		return $return;	
	}
	
	/**
	 * get place extra info
	 */
	public function getPlaceExtraInfo($data, $userId = null){
		$return = array(
			'meta' => array(
				'success' => false,
				'error_message' => ''
			),
			'data' => array()
		);
		if (!isset($data['facebook_id']) || !$data['facebook_id']){
			$return['meta']['error_message'] = 'Empty facebook_id';
			return $return;
		}
		$location = $this->Location->find('first', array(
			'conditions' => array('facebook_id' => $data['facebook_id'])
		));
		$userCount = $this->Photo->find('all', array(
			'conditions' => array(
				'Location.facebook_id' => $data['facebook_id']
			),
			'joins' => array(
				array(
					'table' => 'users',
					'alias' => 'User',
					'type' => 'LEFT',
					'conditions' => array(
						'Photo.user_id = User.id'
					)				
				
				),
				array(
					'table' => 'locations',
					'alias' => 'Location',
					'type' => 'LEFT',
					'conditions' => array(
						'Photo.location_id = Location.id'
					)				
				
				)
			),
			'fields' => array(' COUNT(DISTINCT User.id)')
		));
		
		$photoCount = $this->Photo->find('count', array(
			'conditions' => array(
				'Location.facebook_id' => $data['facebook_id']
			),
			'joins' => array(
				array(
					'table' => 'locations',
					'alias' => 'Location',
					'type' => 'LEFT',
					'conditions' => array(
						'Photo.location_id = Location.id'
					)				
				
				)
			)
		));

		$return['meta']['success'] = true;
		$return['data']['user_count'] = $userCount[0][0]['COUNT(DISTINCT User.id)'];
		$return['data']['photo_count'] = $photoCount;
		$return['data']['Location'] = $location['Location'];
		
		return $return;
	}
	
	/**
	 * get friend's activity
	 */
	public function getFriendActivity($data, $userId = null){
		$itemsPerPage = 40;
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
		if (!isset($data['page']) || !$data['page'] || !($data['page']) || ($data['page'] < 0)){
			$data['page'] = 0;
		}
		$limit = ($itemsPerPage * $data['page']) . "," . $itemsPerPage;
		$users = $this->User->find('all', array(
			'conditions' => array(
				'Follow.from_user_id' => $userId
			),
			'joins' => array(
				array(
					'table' => 'follows',
					'alias' => 'Follow',
					'type' => 'LEFT',
					'conditions' => array(
						'Follow.to_user_id = User.id'
					)
				)				
			),
			'fields' => array('User.id', 'User.username', 'User.profile_picture')
		));
		
		$userIdArray = array();
		$userName = array();
		$profilePicture = array();
		foreach ($users as $user){
			array_push($userIdArray, $user['User']['id']);
			$userName[$user['User']['id']] = $user['User']['username'];
			$profilePicture[$user['User']['id']] = $user['User']['profile_picture'];
		}
		
		$comments = $this->Photo->find('all', array(
			'conditions' => array(
				'Comment.user_id' => $userIdArray

			),
			'joins' => array(
				array(
					'table' => 'users',
					'alias' => 'User',
					'type' => 'LEFT',
					'conditions' => array(
						'Photo.user_id = User.id'
					)
				),
				array(
					'table' => 'comments',
					'alias' => 'Comment',
					'type' => 'LEFT',
					'conditions' => array(
						'Photo.id = Comment.photo_id'
					)
				)				
			),
			'order' => array('Comment.created_time DESC'),
			'fields' => array('Photo.id', 'Photo.thumbnail', 'User.id', 'User.username', 'Comment.id', 'Comment.created_time', 'Comment.user_id'),
			'limit' => $limit	
			)
		);
		
		$likes = $this->Photo->find('all', array(
			'conditions' => array(
				'Like.user_id' => $userIdArray
			),
			'joins' => array(
				array(
					'table' => 'users',
					'alias' => 'User',
					'type' => 'LEFT',
					'conditions' => array(
						'Photo.user_id = User.id'
					)
				),
				array(
					'table' => 'likes',
					'alias' => 'Like',
					'type' => 'LEFT',
					'conditions' => array(
						'Photo.id = Like.photo_id'
					)
				)				
			),
			'order' => array('Like.created_time DESC'),
			'fields' => array('Photo.id', 'Photo.thumbnail', 'User.id', 'User.username', 'Like.id', 'Like.created_time', 'Like.user_id'),
			'limit' => $limit	
			)
		);

		$results = array();
		foreach ($likes as $like){
			if(isset($like['Like']['created_time']) && $like['Like']['created_time']){
				$time = strtotime($like['Like']['created_time']);
				$results[$time][] = array(
					'created_time' => $time,
					'from_user' => $userName[$like['Like']['user_id']],
					'to_user' => $like['User']['username'],
					'type' => 'like',
					'photo_id' => $like['Photo']['id'],
					'thumbnail' => $like['Photo']['thumbnail'],
					'profile_picture' => $profilePicture[$like['Like']['user_id']]
					
				);
			}
		}
		foreach ($comments as $comment){
			if(isset($comment['Comment']['created_time']) && $comment['Comment']['created_time']){
				$time = strtotime($comment['Comment']['created_time']);
				$results[$time][] = array(
					'created_time' => $time,
					'from_user' => $userName[$comment['Comment']['user_id']],
					'to_user' => $comment['User']['username'],
					'type' => 'comment',
					'photo_id' => $comment['Photo']['id'],
					'thumbnail' => $comment['Photo']['thumbnail'],
					'profile_picture' => $profilePicture[$like['Like']['user_id']]
					
				);
			}			
		}
		sort($results);
		$results = array_reverse($results);
		foreach($results as $result){
			foreach($result as $arr){
				$return['data'][] = $arr;
			}
		}

		return $return;
	}
	
	/**
	 * get new photos on feed
	 */
	 public function getListPhotoFeed($data, $userId = null){
		$itemsPerPage = 20;
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
		if (!isset($data['page']) || !$data['page'] || !($data['page']) || ($data['page'] < 0)){
			$data['page'] = 0;
		}
		$limit = ($itemsPerPage * $data['page']) . "," . $itemsPerPage;
		$users = $this->User->find('all', array(
			'conditions' => array(
				'Follow.from_user_id' => $userId
			),
			'joins' => array(
				array(
					'table' => 'follows',
					'alias' => 'Follow',
					'type' => 'LEFT',
					'conditions' => array(
						'Follow.to_user_id = User.id'
					)
				)				
			),
			'fields' => array('User.id')
		));
		
		$userIdArray = array();
		foreach ($users as $user){
			array_push($userIdArray, $user['User']['id']);
		}
		if (!isset($data['page']) || !$data['page'] || !($data['page']) || ($data['page'] < 0)){
			$data['page'] = 0;
		}

		$limit = ($itemsPerPage * $data['page']) . "," . $itemsPerPage;
		$photos = $this->Photo->find('all', array(
			'conditions' => array(
				'user_id' => $userIdArray
			),
			'joins' => array(
				array(
					'table' => 'locations',
					'alias' => 'Location',
					'type' => 'LEFT',
					'conditions' => array(
						'Photo.location_id = Location.id'
					)
				),
				array(
					'table' => 'users',
					'alias' => 'User',
					'type' => 'LEFT',
					'conditions' => array(
						'Photo.user_id = User.id'
					)
				)
			),
			'order' => 'Photo.created_time DESC',
			'fields' => array('Photo.*', 'Location.*', 'User.id', 'User.username', 'User.profile_picture'),
			'limit' => $limit
		));

		//next page
		$return['meta']['next_page'] = $data['page'] + 1;
		if (count($photos) < $itemsPerPage){
			$return['meta']['next_page'] = 0;
		}
				
		
		$return['data'] = $this->getListPhoto($photos, $userId);
		return $return;	
	 }
	 /**
	  * get list Followers
	  */
	public function getListFollowerAndFollowing($data, $userId = null){
		$itemsPerPage = 20;
		$return = array(
			'meta' => array(
				'success' => false,
				'error_message' => ''
			),
			'data' => array()
		);
		if (!isset($data['user_id']) || !$data['user_id']){
			$return['meta']['error_message'] = 'Empty user id';
			return $return;
		}
		if (!isset($data['page']) || !$data['page'] || !($data['page']) || ($data['page'] < 0)){
			$data['page'] = 0;
		}
		
		if (isset($data['type']) && ($data['type'] == 'follower')){
			$conditions = array('Follow.to_user_id' => $data['user_id']);
			$joinConditions = array('Follow.from_user_id = User.id');
		}
		else{
			$conditions = array('Follow.from_user_id' => $data['user_id']);
			$joinConditions = array('Follow.to_user_id = User.id');			
		}
		$conditions['user_had_accepted'] = 1;
		$limit = ($itemsPerPage * $data['page']) . "," . $itemsPerPage;
		
		$result = $this->User->find('all', array(
			'conditions' => $conditions,
			'joins' => array(
				array(
					'table' => 'follows',
					'alias' => 'Follow',
					'type' => 'LEFT',
					'conditions' => $joinConditions
				)				
			),			
			'fields' => array('User.id', 'User.first_name', 'User.last_name', 'User.profile_picture', 'User.username'),
			'limit' => $limit
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
		//next page
		$return['meta']['next_page'] = $data['page'] + 1;
		if (count($result) < $itemsPerPage){
			$return['meta']['next_page'] = 0;
		}
		$return['meta']['success'] = true;
		$return['data'] = $result;
		return $return;		
	}
	
	public function search($data, $userId = null){
		$itemsPerPage = 20;
		$return = array(
			'meta' => array(
				'success' => false,
				'error_message' => ''
			),
			'data' => array()
		);
		if (!isset($data['keyword']) || !$data['keyword']){
			$return['meta']['error_message'] = 'Empty keyword';
			return $return;
		}
		if (!isset($data['page']) || !$data['page'] || !($data['page']) || ($data['page'] < 0)){
			$data['page'] = 0;
		}
		
		$limit = ($itemsPerPage * $data['page']) . "," . $itemsPerPage;
		
		$tags = $this->Photo->find('all', array(
			'conditions' => array(
				'OR' => array(
					array('Photo.tags LIKE' => '#' . $data['keyword'] . '%'),
					array('Photo.tags LIKE' => '%,#' . $data['keyword']. '%') 
				)
			),
			'fields' => array('Photo.tags'),
			'limit' => $limit			
		));
		$tagList = array();
		$tagArray = array();
		
		foreach($tags  as $tag){
			$string = explode(',', $tag['Photo']['tags']);
			if (preg_match('/#' . $data['keyword'] . '/i', $string[0])){
				$tagArray[] = $string[0];
			}
			if (preg_match('/#' . $data['keyword'] . '/i', $string[1])){
				$tagArray[] = $string[1];
			}	
		}
		$tagArray = array_unique($tagArray);
		debug($tagArray);
		foreach($tagArray as $tag){
			$conditionsArray = array(
				'OR' => array(
					array('Photo.tags LIKE' =>  $tag . ',%'),
					array('Photo.tags LIKE' => '%,' . $tag),	
				)	
			);
			$photoCount = $this->Photo->find('count', array(
				'conditions' => $conditionsArray
			));
			$photos = $this->Photo->find('all', array(
				'conditions' => $conditionsArray,
				'joins' => array(
					array(
						'table' => 'users',
						'alias' => 'User',
						'type' => 'LEFT',
						'conditions' => array(
							'Photo.user_id = User.id'
						)				
					
					)
	
				),
				'fields' => array('Photo.id, Photo.thumbnail, User.id')
			));

			
			$userIDArray = array();
			$i = 0;
			foreach ($photos as $photo){
				array_push($userIDArray, $photo['User']['id']);
				
				//chỉ lấy 16 ảnh
				if ($i > 15){
					unset($photos[$i]);
				}
				$i++;
			}
			$userIDArray = array_unique($userIDArray);
			$tagList[] = array(
				'tag' => $tag,
				'photo_count' => $photoCount,
				'Photo' => $photos,
				'user_count' => count($userIDArray)
			);			
		}
		$findString = '%' . $data['keyword'] . '%';
		$user = $this->User->find('all', array(
			'conditions' => array(
				'OR' => array(
					array('username LIKE' => $findString),
					array('first_name LIKE' => $findString),
					array('last_name LIKE' => $findString)  
				)
			),
			'limit' => $limit,
			'fields' => array('id', 'username', 'first_name', 'last_name', 'profile_picture')
		));

		$return['User'] = $user;
		$return['Photo'] = $tagList;
		return $return;
	}
}