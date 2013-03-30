<?php
/**
 * @author thanhdd@lifetimetech.vn
 */
App::uses('Folder', 'Utility');
App::uses('Filters', 'Lib/Filters');
App::uses('Common', 'Lib');
App::import('Controller', 'Api');

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
		if (!isset($_SESSION)) {
			session_start();
		}
		$imgFormat = array('image/gif', 'image/jpeg', 'image/pjeg');	
		$successFlg = false;
		$data = '';
		
		if (!empty($_FILES) && in_array($_FILES["file"]["type"], $imgFormat)) {
			$path = WWW_ROOT . str_replace('/', DS, IMG_TEMP_DIR);
			if (!is_dir($path)) {
				mkdir($path, 0777, true);
				chmod($path, 0777);
			}
			$tmp = $path . session_id() . '.jpg';
			$imgSize = getimagesize($_FILES['file']['tmp_name']);			
			if (($imgSize[0] < 600) || ($imgSize[1] < 600)){
				$data = 'Image size is too small (must be at least 600x600)';
				unlink($_FILES['file']['tmp_name']);				
			}
			else	
				$successFlg = move_uploaded_file($_FILES['file']['tmp_name'], $tmp);
		}
		else {
			$data = 'file not found or invalid image format';
		}

		if ($successFlg){
			$this->redirect(array('controller' => 'upload', 'action' => 'crop'));
		}
		else {
			$this->set('data', $data);
		}
	}
	
	public function crop(){
		if (!isset($_SESSION)) {
			session_start();
		}

		$source = WWW_ROOT . str_replace('/', DS, IMG_TEMP_DIR) . session_id() . '.jpg';
		
		if (!is_file($source)) {
			$this->redirect(array('action' => 'start'));
		}
		$this->set('data', array('source' => $source));	
	}
	
	public function cropProcessing(){
		$this->autoRender = false;
		if (!isset($_SESSION)) {
			session_start();
		}
		
		$source = WWW_ROOT . str_replace('/', DS, IMG_TEMP_DIR) . session_id() . '.jpg';

		if (
			!empty($this->request->data)
			&&
			isset($this->request->data['crop']['x1'])
			&&
			isset($this->request->data['crop']['y1'])
			&&
			isset($this->request->data['crop']['size'])
		) {

			$rootPath = WWW_ROOT . str_replace('/', DS, FILTERS_DIR) . session_id();
			$filterPath = WWW_ROOT . str_replace('/', DS, FILTERS_DIR) . session_id() . DS . 'filter';
			$thumbPath = WWW_ROOT . str_replace('/', DS, FILTERS_DIR) . session_id() . DS . 'thumb';
		
			if (!is_dir($rootPath)) {
				mkdir($rootPath, 0777, true);
				chmod($rootPath, 0777);
			}
			if (!is_dir($filterPath)) {
				mkdir($filterPath, 0777, true);
				chmod($filterPath, 0777);
			}
			if (!is_dir($thumbPath)) {
				mkdir($thumbPath, 0777, true);
				chmod($thumbPath, 0777);
			}
		
			$input = $filterPath . DS . 'input.jpg';
			$thumb = $thumbPath . DS . 'reset.jpg';
			

			$size = getimagesize($source);
			if ($size[0] > $size[1]) {
				$scale = 600 / $size[0];
			} else {
				$scale = 600 / $size[1];
			}
			
			$x = round(intval($this->request->data['crop']['x1']) / $scale);
			$y = round(intval($this->request->data['crop']['y1']) / $scale);
			$size = round(intval($this->request->data['crop']['size']) / $scale);
		
			$Filters = new Filters();
			$Filters->extract($source, $input, $x, $y , $size);
			$Filters->extract($source, $thumb, $x, $y , $size, 76);
			
			// Prepare input and output image
			copy($input, $filterPath . DS . 'source.jpg');
			copy($input, $filterPath . DS . 'output.jpg');
			
			// Prepare filter's preview thumb
			$filterList = array(
				'beauty', 'bright', 'brownish', 'chrome', 'griseous',
				'happytear', 'inkwash', 'instant', 'lomo', 'nostalgia',
				'retro', 'richtone', 'sunrise', 'vibrant', 'xpro'
			);
			
			$Filters->setSource($thumb);
			
			foreach ($filterList as $filterName) {
				$filterThumb = $thumbPath . DS . $filterName . '.jpg';
				$Filters->setDesination($filterThumb);
				$Filters->{$filterName}();
			}
			
		}
		
		return true;		
		
		
	}
	public function filter(){
		
		$source = WWW_ROOT . str_replace('/', DS, IMG_TEMP_DIR) . session_id() . '.jpg';
		$exif = exif_read_data($source, 'ANY_TAG', true);

		if ($exif && isset($exif['GPS'])) {
			$gpsInfo = $exif['GPS'];
		}
		
		if (isset($gpsInfo) && $gpsInfo && isset($gpsInfo['GPSLatitude']) && isset($gpsInfo['GPSLongitude'])) {
			$common = new Common();
			$latlon = $common->triphoto_getGPS($source);
			$latitude = $latlon['latitude'];
			$longitude = $latlon['longitude'];
			$this->set(compact('latitude', 'longitude'));
		}		
	}
	

	
	public function rotate() {
		if (!isset($_SESSION)) {
			session_start();
		}
		
		$this->autoRender = false;
		
		$input = WWW_ROOT . str_replace('/', DS, FILTERS_DIR) . session_id() . DS . 'filter' . DS . 'source.jpg';
		$Filter = new Filters($input, $input);
		$Filter->rotate();
		
		$destination = WWW_ROOT . str_replace('/', DS, FILTERS_DIR) . session_id() . DS . 'filter' . DS . 'output.jpg';
		
		if (!is_file($destination)) {
			copy($input, $destination);
		} else {
			$Filter->setSource($destination);
			$Filter->setDesination($destination);
			$Filter->rotate();
		}
	}
	
	public function reset() {
		if (!isset($_SESSION)) {
			session_start();
		}
		
		$this->autoRender = false;

		
		$pathDir = WWW_ROOT . str_replace('/', DS, FILTERS_DIR) . session_id() . DS . 'filter';
		
		copy($pathDir . DS . 'input.jpg', $pathDir . DS . 'source.jpg');
		copy($pathDir . DS . 'input.jpg', $pathDir . DS . 'output.jpg');
	}
	
	public function magick() {
		if (!isset($_SESSION)) {
			session_start();
		}
		
		$this->autoRender = false;
		Configure::write('debug', 0);

		$filterName = $this->request->data['name'];

		$input = WWW_ROOT . str_replace('/', DS, FILTERS_DIR) . session_id() . DS . 'filter' . DS . 'source.jpg';
		$output = WWW_ROOT . str_replace('/', DS, FILTERS_DIR) . session_id() . DS . 'filter' . DS . $filterName . '.jpg';
		$destination = WWW_ROOT . str_replace('/', DS, FILTERS_DIR) . session_id() . DS . 'filter' . DS . 'output.jpg';
		
		if ($filterName == 'reset'){
			copy($input, $output);
		}
		else{
			$Filter = new Filters($input, $output);
			$Filter->{$filterName}();			
		}

		
		copy($output, $destination);
	}
	
	public function postPhoto(){
		if (!isset($_SESSION)) {
			session_start();
		}
		//Configure::write('debug', 0);
		$data = $this->request->data;
		
		$this->autoRender = false;
		$input = WWW_ROOT . str_replace('/', DS, FILTERS_DIR) . session_id() . DS . 'filter' . DS . 'output.jpg';
		$mask = WWW_ROOT . str_replace('/', DS, FRAMES_DIR) . 'place.png';
		$Filter = new Filters($input, $input);
		
		//add text
		if (isset($data['placeName']) && $data['placeName']){
			if (!isset($data['placeAdd']))
				$data['placeAdd'] = '';
			//limit string length
			if (strlen($data['placeName']) > 27)
				$data['placeName'] = substr($data['placeName'], 0, 24) . '...';
			if (strlen($data['placeAdd']) > 30)
				$data['placeAdd'] = substr($data['placeAdd'], 0, 26) . '...';
			$Filter->frame($mask);
			$Filter->drawText($data['placeName'], $data['placeAdd']);
		}
		
		//add frame
		if ($data['frame'] != 'none'){
			$frame = WWW_ROOT . str_replace('/', DS, FRAMES_DIR) . $data['frame'] . '.png';
			$Filter->frame($frame);
		}
		$userInfo = $this->Auth->user();
		$photo = array('user_id' => $userInfo['User']['id']);
		$Api = new ApiController();


		if (isset($data['id']) && $data['id'] && isset($data['latitude']) && $data['latitude'] && isset($data['longitude']) && $data['longitude']){
			$location = array(
				'facebook_id' => $data['id'],
				'latitude' => $data['latitude'],
				'longitude' => $data['longitude']
			);
			$result = $Api->addLocation($location);
			$locationId = $result['data']['id'];
			$photo['location_id'] = $locationId;	
		}
		$photo['user_had_liked'] = 0;
		$photo['report'] = 0;
		$result = $Api->postPhoto($photo);
		
		if ($result['meta']['success'] && $result['data']['id']){
			$photoId = $result['data']['id'];
			$ouput = WWW_ROOT . str_replace('/', DS, IMG_DIR) . $photoId . '.jpg';
			$thumb = WWW_ROOT . str_replace('/', DS, IMG_DIR) . $photoId . '_thumb.jpg';
			$low = WWW_ROOT . str_replace('/', DS, IMG_DIR) . $photoId . '_low.jpg';
			$tmp = WWW_ROOT . str_replace('/', DS, IMG_TEMP_DIR). session_id() . '.jpg';
			$tmpDir = WWW_ROOT . str_replace('/', DS, FILTERS_DIR) . session_id();
			
			copy($input, $ouput);
			$Filter->extract($ouput, $thumb, 0, 0 , 600, 150);
			$Filter->extract($ouput, $low, 0, 0 , 600, 300);
			unlink($tmp);
			$folder = new Folder($tmpDir);
			$folder->delete();
			echo json_encode(array('status' => 'success', 'id' => $photoId));
		}
		else {
			echo json_encode(array('status' => 'error'));
		}
	}
	
	public function finish($photoId = null){
		if (!isset($_SESSION)) {
			session_start();
		}
		if ($photoId){
			$Api = new ApiController;
			$photoUrl = 'http://' . $_SERVER['SERVER_NAME'] . Router::url(array('controller' => 'img', 'action' => 'upload')) . '/' . $photoId . '.jpg';
			
			$user = $this->Auth->user();
			$data = array('userId' => $user['User']['id']);
			$token = $Api->getSocialToken($data, $data['userId']);
			
			$this->set('token', $token['data']);
			$this->set('photoId', $photoId);
			$this->set('photoUrl', $photoUrl);
		}
	}
	
	public function thumb() {
		if (!isset($_SESSION)) {
			session_start();
		}
		
		$this->autoRender = false;
		Configure::write('debug', 0);

		$filterName = $this->request->data['name'];
		$input = WWW_ROOT . str_replace('/', DS, FILTERS_DIR) . session_id() . DS . 'thumb' . DS . 'reset.jpg';
		$output = WWW_ROOT . str_replace('/', DS, FILTERS_DIR) . session_id() . DS . 'thumb' . DS . $filterName . '.jpg';
		
		$Filter = new Filters($input, $output);
		$Filter->{$filterName}();
	
		echo $filterName . '.jpg';
	}
	
	function test(){
		$this->autoRender = false;
		$input = WWW_ROOT . str_replace('/', DS, FILTERS_DIR) . session_id() . DS . 'filter' . DS . 'source.jpg';
		$output = WWW_ROOT . str_replace('/', DS, FILTERS_DIR) . session_id() . DS . 'filter' . DS . 'test.jpg';
		$mask = WWW_ROOT . str_replace('/', DS, FRAMES_DIR) . 'place.png';
		$source = WWW_ROOT . str_replace('/', DS, IMG_TEMP_DIR) . session_id() . '.jpg';
		

		$Filter = new Filters($input, $output);
		$Filter->frame($mask);
		$txt = 'Cầu Long Biên';

		if (strlen($txt) > 27)
			 $txt = substr($txt, 0, 24) . '...';
		$txt2 = 'DUY TAN, HANOI | VIETNAMVIETNAMVIETNAMVIETNAMVIETNAM';
		if (strlen($txt2) > 30)
			 $txt2 = substr($txt2, 0, 26) . '...';
		$Filter->drawText($txt, $txt2);

		
	}
}