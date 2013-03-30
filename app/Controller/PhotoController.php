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
		if (!$photoId){
			die;
		}
		$Api = new ApiController();
		$Api->getPhotoDetail();
	}
}