<?php
/**
 * @author thanhdd@lifetimetech.vn
 */
App::uses('Filters', 'Lib/Filters');
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
		
	}
	public function finish(){
		
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
		
		$Filter = new Filters($input, $output);
		$Filter->{$filterName}();
		
		copy($output, $destination);
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
		
		$Filter = new Filters($input, $output);
		$Filter->frame($mask);
		$txt = 'VIETA BUILDING';
		$txt2 = 'DUY TAN, HANOI | VIETNAM';
		$Filter->drawText($txt, $txt2);
		debug(exif_read_data($input));
		
	}
}