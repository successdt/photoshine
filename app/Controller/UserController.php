<?php
/**
 * @author thanhdd@lifetimetech.vn
 */
App::uses('Folder', 'Utility');
App::uses('Common', 'Lib');
App::import('Controller', 'Api');
App::uses('Filters', 'Lib/Filters');

class UserController extends AppController{
	public $name = 'User';
	public function beforeFilter() {
		parent::beforeFilter();
	}
	
	public function editProfile(){
		if (!isset($_SESSION)) {
			session_start();
		}
		$userInfo = $this->Auth->user();
		$Api = new ApiController();
		$result = $Api->getYourData(array(), $userInfo['User']['id']);
		if (isset($result['meta']['success']) && $result['meta']['success']){
			$this->set('user', $result['data']);
		}		
	}
	
	public function editProfileExec(){
		if (!isset($_SESSION)) {
			session_start();
		}
		$this->autoRender = false;
		if (!isset($this->request->data))
			return;
		$data = $this->request->data;
		
		$user = $this->Auth->user();
		$imgFormat = array('image/png', 'image/jpeg', 'image/pjeg');	
		$successFlg = false;
		$bug = '';		
		if (!empty($_FILES) && in_array($_FILES["file"]["type"], $imgFormat)) {
			$path = WWW_ROOT . str_replace('/', DS, PROFILE_DIR);
			if (!is_dir($path)) {
				mkdir($path, 0777, true);
				chmod($path, 0777);
			}
			$tmp = $path . $user['User']['id'] . '.jpg';
			$imgSize = getimagesize($_FILES['file']['tmp_name']);			
			if (($imgSize[0] < 150) || ($imgSize[1] < 150)){
				$bug = 'Image size is too small (must be at least 150x150)';
				unlink($_FILES['file']['tmp_name']);				
			}
			else {
				$originSize = ($imgSize[1] >= $imgSize[0]) ? $imgSize[0] : $imgSize[1];
				$successFlg = move_uploaded_file($_FILES['file']['tmp_name'], $tmp);
				$Filter = new Filters($tmp, $tmp);
				$Filter->extract($tmp, $tmp, 0, 0 , $originSize, 150);
			}
				
		}
		else {
			$bug = 'file not found or invalid image format';
		}
		
		$data['profile_picture'] = 'profile/' . $user['User']['id'] . '.jpg';
		$Api = new ApiController;
		$Api->updateYourData($data, $user['User']['id']);
		$this->redirect(array('controller' => 'u', 'action' => $user['User']['username']));		
	}
	
	public function changePassword(){
		if (!isset($_SESSION)) {
			session_start();
		}
	}
	
	public function findFriends(){
		if (!isset($_SESSION)) {
			session_start();
		}
//		$data['ids'] = '100002394657144,100001695550801';
//		$data['type'] = 'facebook';
				
		$user = $this->Auth->user();
		$data = array('userId' => $user['User']['id']);
		$Api = new ApiController;		
		$token = $Api->getSocialToken($data, $data['userId']);
		
		$this->set('token', $token['data']);		
	}
	
	public function servicesMan(){
		if (!isset($_SESSION)) {
			session_start();
		}		
		$user = $this->Auth->user();
		$data = array('userId' => $user['User']['id']);
		$Api = new ApiController;		
		$token = $Api->getSocialToken($data, $data['userId']);
		
		$this->set('token', $token['data']);		
	}
	
	public function feedback(){
		if (!isset($_SESSION)) {
			session_start();
		}		
	}
	
	public function timeline($username = null){
		if (!isset($_SESSION)) {
			session_start();
		}
		if ($username){
			$data['name'] = $username;
			$Api = new ApiController;		
			$data = $Api->getUserInfo($data);
			if(isset($data['data']['User']) && $data['data']['User']){
				$this->set('data', $data['data']);
			}			
		}		
	}
}