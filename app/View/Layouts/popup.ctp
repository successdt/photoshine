<!DOCTYPE html>
<html lang="en">
<head>

	<meta charset="utf-8"/>
	<link rel="shortcut icon" href="<?php echo $this->Html->url('/img/favicon.ico') ?>" type="image/x-icon">
	<title>
		<?php echo $title_for_layout; ?>
	</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<meta name="description" content=""/>
	<meta name="author" content=""/>

	<?php echo $this->Html->css(array('bootstrap.min', 'app'), 'stylesheet') ?>
	<?php echo $this->fetch('css'); ?>
	
</head>

<body>

	<div id="popup-container">
		<?php echo $this->fetch('content') ?>
	</div>

	<!-- javascript
	================================================== -->
	<?php 
		echo $this->Html->script(array(
			'jquery.min',
			'bootstrap.min',
			'common'
		)) 
	?>
	
	<?php echo $this->fetch('script'); ?>
	<?php echo $this->Html->scriptStart(array('inline' =>false)) ?>
	//<script>
	$(document).ready(function(){
		$('a').tooltip({});
	});
	<?php echo $this->Html->scriptEnd() ?>
</body>
</html>
