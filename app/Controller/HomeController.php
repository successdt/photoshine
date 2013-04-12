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
		if (!isset($_SESSION)) {
			session_start();
		}
		$data = array();
		$user = $this->Auth->user();
		$Api = new ApiController;		
		$data = $Api->getFriendActivity($data, $user['User']['id']);
		$this->set('activities', $data['data']);				
	}
	
	public function search($keyword = null){
		if (!isset($_SESSION)) {
			session_start();
		}
		if($keyword){
			$Api = new ApiController;
			$response = $Api-> search(array('keyword' => $keyword));
			debug($response);
			die;
		}		
	}
	
}