<!DOCTYPE html>
<html lang="en">
<head>

	<meta charset="utf-8"/>
	<link rel="shortcut icon" href="<?php echo $this->Html->url('/img/favicon.ico') ?>" type="image/x-icon">
	<title>
		<?php echo isset($title_description) ? $title_description :  $title_for_layout; ?>
	</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<meta name="description" content=""/>
	<meta name="author" content=""/>
	<?php echo $this->fetch('meta'); ?>
	
	<?php echo $this->Html->css(array('bootstrap.min', 'app', 'slidebox'), 'stylesheet') ?>
	<?php echo $this->fetch('css'); ?>
</head>

<body>
	<div id="header" class="navbar navbar-fixed-top">
		<?php echo $this->element('Layouts/navbar') ?>		
	</div><!-- // END HEADER -->
	
	<div id="sidebar">
	</div><!-- // END SIDEBAR -->
	
	<div id="content">
		
		<?php echo $this->fetch('content') ?>
	</div><!-- // END CONTENT -->

	<div id="footer">

	</div><!-- // END FOOTER -->
	<div id="tool-pane">
		<div class="loading">
			<?php echo $this->Html->image('photoshine/loading.gif', array('width' => '32', 'height' => '32')); ?>
		</div>
		
		<a href="#" >
			<?php echo $this->Html->image('photoshine/back_to_top.png', array('width' => '32', 'height' => '32')); ?>		
		</a>
	</div>
	<!-- javascript
	================================================== -->
	<?php echo $this->Html->script(array(
//		'live',
		'jquery.min',
		'slidebox',
		'bootstrap.min',
		'common'
	)) ?>
	<?php echo $this->fetch('script'); ?>
	
	<?php echo $this->Html->scriptStart() ?>
		$(document).ready(function(){
			$('a').tooltip({});
		});
	<?php echo $this->Html->scriptEnd() ?>
</body>
</html>