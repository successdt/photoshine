<?php
App::import('Controller', 'Api');
class AccountController extends AppController{
	public $name = 'Account';
	public $layout = 'not_login';
	
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
}