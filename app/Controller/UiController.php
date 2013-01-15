<?php
class UiController extends AppController {
	var $layout = 'default';
	public function layout(){
		
	}
	public function timeline(){
		
	}
	public function photoDetail(){
		$this->layout = 'popup';
	}
}