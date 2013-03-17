<?php
App::import('Controller', 'Api');
class HomeController extends AppController{
	public $name = 'Home';
	public $layout = 'default';
	
	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow('index');
	}
	public function index(){
		$this->layout = 'not_login';
		if ($this->Auth->loggedIn())
			$this->redirect(array('controller' => 'home', 'action' => 'feed'));
	}
	public function feed(){
	}
	
}