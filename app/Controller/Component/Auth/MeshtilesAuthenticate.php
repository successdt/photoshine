<?php
App::uses('BaseAuthenticate', 'Controller/Component/Auth');
App::uses('MeshtilesApi', 'Lib/Meshtiles');
App::uses('Common', 'Lib');

class MeshtilesAuthenticate extends BaseAuthenticate {
	
	public function authenticate(CakeRequest $request, CakeResponse $response) {
		if (!isset($request->query['access_token']) || !isset($request->query['refresh_token'])) {
			return false;
		}

		$userProfile = MeshtilesApi::instance()->callAPI('getUserProfile', array(
			'access_token' => $request->query['access_token']
		));

		if (!$userProfile) {
			return false;
		}
		
		/* Get Favourist Tag */
		$favouristTag = array();
		
		$getFavouristTag = MeshtilesApi::instance()->callAPI(
			'getFavouristTags',
			array_merge(array('access_token' => $request->query['access_token']), Configure::read('Meshtiles.config'))
		);
		
		if (isset($getFavouristTag['tag']) && $getFavouristTag['tag']) {
			$favouristTag = Set::combine($getFavouristTag['tag'], '{n}.tag_name', '{n}.number_post');
			$favouristTag = array_map('Common::toNumberSize', $favouristTag);
		}
		
		$temp = array();
		foreach ($favouristTag as $tag => $number) {
			array_push($temp, "{id: '{$tag}', text: '{$tag}', number: '$number'}");
		}
		
		$favouristTag = '[' . implode(',', $temp) . ']';
		
		/* Get Frequent Tag */
		$frequentTag = array();
		
		$getFrequentTag = MeshtilesApi::instance()->callAPI(
			'getFrequentTags',
			array_merge(array('access_token' => $request->query['access_token']), Configure::read('Meshtiles.config'))
		);
		
		if (isset($getFrequentTag['tag']) && $getFrequentTag['tag']) {
			$frequentTag = Set::combine($getFrequentTag['tag'], '{n}.tag_name', '{n}.number_post');
			$frequentTag = array_map('Common::toNumberSize', $frequentTag);
		}
		
		$temp = array();
		foreach ($frequentTag as $tag => $number) {
			array_push($temp, "{id: '{$tag}', text: '{$tag}', number: '$number'}");
		}
		
		$frequentTag = '[' . implode(',', $temp) . ']';
		
		return array(
			'provider' => 'Meshtiles',
			'uid' => $userProfile['user_id'],
			'info' => array(
				'user_name' => $userProfile['user_name'],
				'name' => $userProfile['first_name'] . $userProfile['last_name'],
				//'image' => ??
			),
			'credentials' => array(
				'access_token' => $request->query['access_token'],
				'refresh_token' => $request->query['refresh_token']
				//'expires' => ??
			),
			'others' => array(
				'favourite_tag' => $favouristTag,
				'frequent_tag' => $frequentTag,
			)
		);
	}
}