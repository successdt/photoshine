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
		$Api = new ApiController;
		
		$Facebook = new Facebook($facebookConfig);
		$Facebook->setAccessToken(FB_TOKEN);
		$response = $Facebook->api("/search?type=place&center=$latitude,$longitude&distance=1000&limit=50&access_token=" . FB_TOKEN);

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
	public function place($placeId = null){
		if (!isset($_SESSION)) {
			session_start();
		}
		if (!$placeId){
			die;
		}
		$Api = new ApiController;
		$response = $Api->getPlaceExtraInfo(array('facebook_id' => $placeId));
		
		if (isset($response['data']) && $response['data']){
			$this->set('location', $response['data']);
			
		    $fql = 'SELECT name,description,type,location FROM page WHERE page_id="' . $placeId . '"';
		    $result = json_decode(file_get_contents('https://graph.facebook.com/fql?q=' . rawurlencode($fql) . '&access_token=' . FB_TOKEN), true);
		    
		    $locationName = '';
		    if (isset($result['data'][0]['name'])){
		    	$locationName = $result['data'][0]['name'];
		    }

		    $addArray = array();
		    if (isset($result['data'][0]['location']['city']))
		    	$addArray[0] = $result['data'][0]['location']['city'];
		    if (isset($result['data'][0]['location']['country']))
		    	$addArray[1] = $result['data'][0]['location']['country'];
	    	$locationAddress = implode('-', $addArray);
	    	
	    	$this->set(compact('locationName', 'locationAddress'));

		}
		
	}

}