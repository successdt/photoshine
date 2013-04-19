<?php
App::uses('CakeEmail', 'Network/Email');
App::import('Controller', 'Api');
class AccountController extends AppController{
	public $name = 'Account';
	public $layout = 'not_login';
	public $component = array();
	
	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow('*');
	}
	
	public function login(){
		if (!isset($_SESSION)) {
			session_start();
		}
		$this->Auth->logout();
		//$this->Auth->login(array('id' => 69));
	}
	public function signup(){
		$this->Auth->logout();
	}
	public function logout(){
		$this->autoRender = false;
//		debug($this->Auth->user());
		$this->Auth->logout();
		$this->redirect(array('controller' => 'account', 'action' => 'login'));
	}
	public function resetPassword(){
		$this->autoRender = false;
		$data = $this->request->data;
		if(isset($data['username']) && $data['username']){
			$Api = new ApiController();
			$response = $Api->resetPassword($data);
			if($response['meta']['success']){
				$Email = new CakeEmail('smtp');
				$Email->from(array('success.ddt@gmail.com' => 'Photoshine.tk'));
				$Email->to($response['data']['email'] );
				$Email->subject('Reset password');
				$Email->send('Hello ' . $data['username'] . '!  Your new passwod of user ' . $data['username'] . ' at http://photoshine.tk is : ' . $response['data']['pwd']);
				unset($response['data']['pwd']);
				
			}
			echo json_encode($response);
		}
	}
}