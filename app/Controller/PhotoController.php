<?php
/**
 * @author thanhdd@lifetimetech.vn
 */
App::uses('Common', 'Lib');
App::import('Controller', 'Api');

class PhotoController extends AppController{
	public $name = 'Photo';
	public function beforeFilter() {
		parent::beforeFilter();
	}
	
	public function detail($photoId = null){
		$this->layout = 'popup';
		if (!$photoId){
			die;
		}
		$user = $this->Auth->user();
		$Api = new ApiController();
		$photo = $Api->getPhotoDetail(array('id' => $photoId), $user['User']['id']);
		$data = array('userId' => $user['User']['id']);
		$token = $Api->getSocialToken($data, $data['userId']);
		
		$this->set('token', $token['data']);
		$this->set('data', $photo['data']);
	}
	
	public function channel($name = null){
		if (!isset($_SESSION)) {
			session_start();
		}
		if (!$name){
			die;
		}
		$Api = new ApiController();
		$photo = $Api->getChannelExtraInfo(array('tag' => $name));

		$this->set('channel', $name);
		$this->set('data', $photo['data']);	
	}
	
	public function myLikes(){
		if (!isset($_SESSION)) {
			session_start();
		}
		$user = $this->Auth->user();
		$data = array('userId' => $user['User']['id']);
		$Api = new ApiController;		
		$photo = $Api->getYourLiked($data, $data['userId']);
		
		$this->set('data', $photo['data']);		
	}
	
	public function popular(){
		if (!isset($_SESSION)) {
			session_start();
		}	
	}
}