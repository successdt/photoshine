<?php
/**
 * @author thanhdd@lifetimetech.vn
 */
class ApiController extends AppController {
	public $uses = array('User', 'Photo', 'Location');
	
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
		$userInfo['password'] = md5($userInfo['password']);
		$userInfo['username'] = strtolower($userInfo['username']);
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
		$output = str_replace('/', DS, IMG_DIR);
		
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
	public function updatePhoto($photoId, $data){
		$return = array(
			'meta' => array(
				'success' => false,
				'error_message' => ''
			),
			'data' => array('id' => $photoId)
		);
		
		if (!isset($photoId) && $photoId){
			$return['meta']['error_message'] = 'Empty photo id';
			return $return;
		}
		$this->Photo->id = $photoId;
		$this->Photo->save($data);
		
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
	public function updateUser($userId, $data){
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
		$this->User->id = $photoId;
		$this->User->save($data);
		$return['meta']['success'] = true;
		
		return $return;						
	}
}