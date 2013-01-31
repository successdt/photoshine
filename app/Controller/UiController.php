<?php
class UiController extends AppController {
	var $layout = 'default';
	public function layout(){
		
	}
	public function timeline(){
		
	}
	public function location(){}
	public function channel(){}
	public function searchResult(){}
	public function nearby(){}
	public function popular(){}
	public function myLikes(){}
	public function settings(){}
	public function changePassword(){}
	public function servicesMan(){}
	public function feedback(){}
	public function help(){}
	public function privac(){}
	public function findFriends(){}
	public function feed(){}
	public function upload(){
		$this->layout = 'popup';
	}
	public function notifications(){
		$this->layout = 'popup';
	}
	public function photoDetail(){
		$this->layout = 'popup';
	}
}