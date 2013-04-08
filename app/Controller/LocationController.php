<?php
/**
 * @author thanhdd@lifetimetech.vn
 */
App::uses('Common', 'Lib');
App::import('Controller', 'Api');
App::uses('Facebook', 'Lib/Facebook');
class LocationController extends AppController{
	public $name = 'Location';
	public function beforeFilter() {
		parent::beforeFilter();
	}
	
	public function nearby($latitude = 0, $longitude = 0){
		if (!isset($_SESSION)) {
			session_start();
		}
		$facebookConfig = Configure::read('Facebook.config');;
		$user = $this->Auth->user();
		$data['userId'] = '';
		if (isset($user['User']['id']))
			$data['userId'] = $user['User']['id'];
		$Api = new ApiController;
		$response = $Api->getSocialToken($data, $data['userId']);							
		$token = $response['data'];
		
		$Facebook = new Facebook($facebookConfig);
		$Facebook->setAccessToken($token['facebook_token']);
		$Facebook->setFileUploadSupport(true);
		$facebookArgs = array(
			'type' => 'place',
			'center' => $latitude . ',' . $longitude,
			'distance' => 1000
		);
		$response = $Facebook->api("/search?type=place&center=$latitude,$longitude&distance=1000&limit=50&access_token=" . $token['facebook_token']);

		if (isset($response['data']) && count($response['data'])){
			$locationId = array();
			foreach($response['data'] as $location){
				array_push($locationId, $location['id']);
			}
			$locationInfo = $Api->getLocationInfo(array('location' => $locationId));
			$locationInfo = $locationInfo['data'];
			$locations = $response['data'];
			$this->set(compact('latitude', 'longitude', 'locations', 'locationInfo'));
		}
	}

}