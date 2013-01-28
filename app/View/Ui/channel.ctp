<div class="timeline-cover-bg" style="height: 200px;">
	<div>
	<?php
	for ($i = 1; $i <= 100; $i++):
		//echo $this->Html->image('http://placehold.it/50x50');
		echo $this->Html->image('tmp/tmp' . rand(1, 5) . '.jpg', array('width' => '50', 'height' => '50', 'class' => 'low'));
		if ($i % 4 == 0)
			echo $this->Html->image('tmp/tmp' . rand(6, 10) . '.jpg', array('width' => '100', 'height' => '100', 'class' => 'hi'));
	endfor ?>	
	</div>

</div>
<div class="location-info">
	<div class="location-info-inner">
		<div class="location-info-left">
			<div class="left-text">
				<span style="font-size: 50px;">60</span>
				<span>Photos</span>			
			</div>
		</div>
		<div class="location-info-center ellipsis">
			<span>
				<h2>#travel</h2>
			</span>
			
			
		</div>
		<div class="location-info-right">
			<div class="right-text">
				<span style="font-size: 50px;">30</span>
				<span>Users</span>			
			</div>		
		</div>	
	</div>

</div>
<?php echo $this->element('photos_view'); ?>
<?php echo $this->Html->script(array('jquery.masonry.min', 'jquery.imagesloaded'), array('inline' => false)) ?>
<?php echo $this->Html->scriptStart(array('inline' => false)) ?>
//<script>
	$(document).ready(function(){
		$('.timeline-cover-bg div img').imagesLoaded(function(){
			$('.timeline-cover-bg div').masonry({});	
		});
	});
<?php echo $this->Html->scriptEnd() ?>