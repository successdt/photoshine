<?php 
if (isset($channel) && $channel && $data['photo']):
?>
<div class="timeline-cover-bg" style="height: 200px;">
	<div>
	<?php	
	for ($i = 0; $i <= 100; $i++):
		$j = $i % count($data['photo']);
		echo $this->Html->image($data['photo'][$j]['Photo']['thumbnail'], array('width' => '50', 'height' => '50', 'class' => 'low'));
		if ($i % 4 == 0)
			echo $this->Html->image($data['photo'][$j]['Photo']['thumbnail'], array('width' => '100', 'height' => '100', 'class' => 'hi'));
	endfor ?>	
	</div>

</div>
<div class="location-info">
	<div class="location-info-inner">
		<div class="location-info-left">
			<div class="left-text">
				<span style="font-size: 50px;"><?php echo $data['photo_count'] ?></span>
				<span>Photos</span>			
			</div>
		</div>
		<div class="location-info-center ellipsis">
			<span>
				<h2>#<?php echo h($channel) ?></h2>
			</span>
			
			
		</div>
		<div class="location-info-right">
			<div class="right-text">
				<span style="font-size: 50px;"><?php echo $data['user_count'] ?></span>
				<span>Users</span>			
			</div>		
		</div>	
	</div>

</div>
<?php
	echo $this->element('photos_view', array(
		'requestUrl' => $this->Html->url(array('controller' => 'ajax', 'action' => 'callApi', 'getListPhotoByChannel')),
		'requestParams' => "tag: '$channel'"
	));
endif;
?>
<?php echo $this->Html->script(array('jquery.masonry.min', 'jquery.imagesloaded'), array('inline' => false)) ?>
<?php echo $this->Html->scriptStart(array('inline' => false)) ?>
//<script>
	$(document).ready(function(){
		$('.timeline-cover-bg div img').imagesLoaded(function(){
			$('.timeline-cover-bg div').masonry({});	
		});
	});
<?php echo $this->Html->scriptEnd() ?>