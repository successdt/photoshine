<?php
/**
 * @author thanhdd@lifetimetech.vn
 */
class UploadController extends AppController{
	public $name = 'Upload';
	public $layout = 'popup';
	public function beforeFilter() {
		parent::beforeFilter();
		if(!$this->Auth->loggedIn())
			die;
	}
	
	/**
	 * choose file for upload
	 */
	public function start(){
		
	}
	
	public function upload(){
		
	}
	public function crop(){
		
	}
	public function filter(){
		
	}
	public function finish(){
		
	}
}