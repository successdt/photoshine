<?php
class Filters {
	
	public $input = null;
	
	public $output = null;
	
	public function __construct($input = null, $output = null) {
		$this->input = $input;
		$this->output = $output;
	}
	
	public function setSource($input = null) {
		$this->input = $input;
	}
	
	public function setDesination($output = null) {
		$this->output = $output;
	}
	
	public function __call($name, $arguments) {
		if (isset($arguments[0])) {
			$this->setSource($arguments[0]);
		}
		if (isset($arguments[1])) {
			$this->setDesination($arguments[1]);
		}
		
		if (!method_exists($this, $name) || !is_string($this->input) || !is_file($this->input) || !is_string($this->output)) {
			return false;
		}
		
		$this->{$name}();
		
		return true;
	}
	
	private function execute($command) {
		// remove newlines and convert single quotes to double to prevent errors
		$command = str_replace(array("\n", "'"), array('', '"'), $command);
		// replace multiple spaces with one
		$command = preg_replace('#(\s){2,}#is', ' ', $command);
		// escape shell metacharacters
		$command = escapeshellcmd($command);
		// execute convert program
		exec($command);
	}
	
	public function extract($input, $output, $x = 0, $y = 0, $size = 600, $outputSize = 600) {
		$this->execute("convert -extract '{$size}x{$size}+{$x}+{$y}' $input -resize '{$outputSize}x{$outputSize}' $output");
	}
	
//	private function composite($input, $mask, $alpha = '50', $mode = 'Multiply') {
//		$tmp =  WWW_ROOT . str_replace('/', DS, FILTERS_DIR) . uniqid('', true) . '.png';
//		$this->execute("convert $mask -alpha opaque -channel a -evaluate set $alpha% +channel $tmp");
//		$this->execute("convert $input $tmp -compose $mode -composite $input");
//		unlink($tmp);
//	}
	
//	private function alpha($input, $alpha, $type = 'jpeg', $width = 600, $height = 600) {
//		$tmp =  WWW_ROOT . str_replace('/', DS, FILTERS_DIR) . uniqid('', true) . '.jpg';
//		copy($input, $tmp);
//		$this->execute("convert $tmp -channel A -evaluate 50% $tmp");
//		return $tmp;
//	}
	
	private function thumbnail($input, $size = 120) {
		$this->execute("convert $this->input -resize {$size}x{$size} $this->output");
	}
	
	private function beauty() {
		$this->execute("convert $this->input -color-matrix '1.3 0 0 0   0 1.3 0 0   0 0 1.3 0   0 0 0 1' $this->output");
		//matrix reg green blue alpha
	}
	
	private function bright() {
		$this->execute("convert $this->input -color-matrix '1.3 0 0 0   0 1.3 0 0   0 0 1.3 0   0 0 0 1' -brightness-contrast '10, 12' $this->output");
	}
	
	private function brownish() {
		$mask = WWW_ROOT . str_replace('/', DS, MASKS_DIR) . 'brownish_overlay_0.5.jpg';
		$this->execute("convert
			{$this->input}
			{$mask}
			( -clone 0 -color-matrix '1 .2 0 0   .1 1 0 0   0 0 1 0   0 0 0 1' )
			( -clone 1 -alpha opaque -channel a -evaluate set 50% +channel )
			-compose Overlay -composite 
			{$this->output}
		");
	}
	
	private function chrome() {
		$mask = WWW_ROOT . str_replace('/', DS, MASKS_DIR) . 'chrome_softlight_1.0.png';
		$this->execute("convert
			{$this->input}
			-color-matrix '.35 .35 .35 0   .35 .35 .35 0   .35 .35 .35 0   0 0 0 1'
			-brightness-contrast '-15.68, 12'
			{$mask}
			-compose softlight -composite 
			{$this->output}
		");
	}
	
	private function griseous() {
		$mask = WWW_ROOT . str_replace('/', DS, MASKS_DIR) . 'griseuos_multiply_0.3.jpg';
		$this->execute("convert
			{$this->input}
			-color-matrix '1 0 0 0   0 1 .1 0   0 .2 1 0   0 0 0 1'
			-set option:modulate:colorspace HSB -modulate '90, 50'
			-brightness-contrast '0, 15'
			( {$mask} -alpha opaque -channel a -evaluate set 50% +channel )
			-compose Multiply -composite
			{$this->output}
		");
	}
	
	private function happytear() {
		$mask = WWW_ROOT . str_replace('/', DS, MASKS_DIR) . 'happytear_overlay_0.45.png';
		$this->execute("convert
			{$this->input}
			( {$mask} -alpha opaque -channel a -evaluate set 45% +channel )
			-compose Overlay -composite
			{$this->output}
		");
	}
	
	private function inkwash() {
		$mask = WWW_ROOT . str_replace('/', DS, MASKS_DIR) . 'inkwash_overlay_0.8.jpg';
		$this->execute("convert
			{$this->input}
			-color-matrix '.25 .25 .25 0   .25 .25 .25 0   .35 .3 .3 0   0 0 0 1'
			-brightness-contrast '0, 6'
			( {$mask} -alpha opaque -channel a -evaluate set 80% +channel )
			-compose Overlay -composite
			{$this->output}
		");
	}
	
	private function instant() {
		$mask = WWW_ROOT . str_replace('/', DS, MASKS_DIR) . 'instant_multiply_0.6.jpg';
		$this->execute("convert
			{$this->input}
			-set option:modulate:colorspace HSB -modulate '100, 50'
			-brightness-contrast '0, 15'
			-color-matrix '1 0 0 0   .03 1 .03 0   0 0 1 0   0 0 0 1'
			( {$mask} -alpha opaque -channel a -evaluate set 60% +channel )
			-compose Multiply -composite
			{$this->output}
		");
	}
	
	private function lomo() {
		$mask = WWW_ROOT . str_replace('/', DS, MASKS_DIR) . 'lomo_overlay_1.0.jpg';
		$this->execute("convert
			{$this->input}
			-color-matrix '1.2 0 0 -0.1   0 1.2 0 -0.1   0 0 1.2 -0.1   0 0 0 1'
			-modulate '80, 100, 105'
			{$mask}
			-compose Overlay -composite
			{$this->output}
		");
	}
	
	private function nostalgia() {
		$mask1 = WWW_ROOT . str_replace('/', DS, MASKS_DIR) . 'nostalgia_sortlight_0.7.png';
		$mask2 = WWW_ROOT . str_replace('/', DS, MASKS_DIR) . 'nostalgia_multiply_1.0.jpg';
		$this->execute("convert
			{$this->input}
			( {$mask1} -alpha opaque -channel a -evaluate set 70% +channel )
			-compose softlight -composite
			{$mask2}
			-compose Multiply -composite
			{$this->output}
		");
	}
	
	private function retro() {
		$mask = WWW_ROOT . str_replace('/', DS, MASKS_DIR) . 'retro_multiply_0.7.jpg';
		$this->execute("convert
			{$this->input}
			-set option:modulate:colorspace HSB -modulate '70, 50'
			( {$mask} -alpha opaque -channel a -evaluate set 70% +channel )
			-compose Multiply -composite
			-set option:modulate:colorspace HSB -modulate '150'
			{$this->output}
		");
	}
	
	private function richtone() {
		$mask = WWW_ROOT . str_replace('/', DS, MASKS_DIR) . 'richtone_colorburn_0.5.jpg';
		$this->execute("convert
			{$this->input}
			-color-matrix '1.2 0 0 0   0 1.25 0 0   0 0 1 0   0 0 0 1'
			( {$mask} -alpha opaque -channel a -evaluate set 50% +channel )
			-compose color-burn -composite
			{$this->output}
		");
	}
	
	private function sunrise() {
		$this->execute("convert
			{$this->input}
			-color-matrix '1 .08 .08 .08   0 1 0 0   0 0 1 0   0 0 0 1'
			-set option:modulate:colorspace HSB -modulate '110, 80'
			{$this->output}
		");
	}
	
	private function vibrant() {
		$this->execute("convert
			{$this->input}
			-color-matrix '1.5 0 0 .1   0 1.5 0 .1   0 0 1.5 .1   0 0 0 1'
			-brightness-contrast '-15, 10'
			{$this->output}
		");
	}
	
	private function xpro() {
		$mask = WWW_ROOT . str_replace('/', DS, MASKS_DIR) . 'xpro_multiply_0.8.jpg';
		$this->execute("convert
			{$this->input}
			-color-matrix '1.5 0 0 .1   0 1.5 0 .1   0 0 1.5 .1   0 0 0 1'
			-set option:modulate:colorspace HSB -modulate '85, 120, 105'
			( {$mask} -alpha opaque -channel a -evaluate set 80% +channel )
			-compose Multiply -composite
			{$this->output}
		");
	}
	
	
	private function rotate() {
		$this->execute("convert
			{$this->input}
			-rotate '-90'
			{$this->output}
		");
	}
	
	public function frame($frame, $with = 600, $height = 600)
    {
        $this->execute("convert {$this->input} ( '$frame' -resize {$with}x{$height}! -unsharp 1.5×1.0+1.5+0.02 ) -flatten {$this->output}");
    }
	public function drawText($text = '', $text2 = ''){
		$str = 'convert ' . $this->output . ' -fill white -gravity South -pointsize 36 -undercolor none -annotate +60+60  \'' . $text . '\' append ' . $this->output;
		$this->execute($str);
		$str = 'convert ' . $this->output . ' -fill white -gravity South -pointsize 28 -undercolor none -annotate +60+10  \'' . $text2 . '\' append ' . $this->output;
		$this->execute($str);
	}
	public function border($color = 'black', $width = 20)
    {
        $this->execute("convert {$this->input} -bordercolor $color -border {$width}x{$width} {$this->output}");
    }
}