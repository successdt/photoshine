<?php
/**
 * @author thanhdd@lifetimetech.vn
 */
App::import('Controller', 'Api');
class AjaxController extends AppController{
	public $name = 'Ajax';
	public function beforeFilter() {
		parent::beforeFilter();
		$this->autoRender = false;
		$this->Auth->allow('callApi');
//		if(!$this->Auth->loggedIn())
//			die;
	}
	
	/**
	 * process api call
	 */
	public function callApi($apiName = null){
		$data = $this->request->data;
		$user = $this->Auth->user();
		$userId = '';
		//tự động gắn thêm tham số userId
			
		if (!$apiName){
			$return['meta']['error_message'] = 'Empty api name';
			return json_encode($return);
		}
		if (!$data){
			$return['meta']['error_message'] = 'Empty request data';
			return json_encode($return);
		}
		
		if (isset($user['User']['id']))
			$userId = $user['User']['id'];
		
		$Api = new ApiController();
		$result = $Api->{$apiName}($data, $userId);
		
		//case login
		if ((($apiName == 'login') || ($apiName == 'registerUser')) && ($result['data']['status'] == 'ok'))
			$this->Auth->login($result['data']);
		return json_encode($result);
	}
	
	public function test(){
		$Api = new ApiController();
		$result = $Api->getNotification(array(), 1);
		debug($result);		
	} 
}