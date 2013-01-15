<?php echo $this->Html->css('timeline') ?>
<div class="timeline-cover-bg">
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
<div class="timeline-cover">
	<div class="timeline-cover-inner">
		<div class="timeline-cover-avatar">
			<?php echo $this->Html->image('photoshine/common_default_avatar.png') ?>
		</div>
	</div>
</div>
<div class="gridview-wrapper">
<?php for ($i = 0; $i < 32; $i++): ?>
	<div class="gridview-block">
		<div class="gridview-image">
			<?php echo $this->Html->link(
				$this->Html->image('tmp/tmp' . rand(1, 10) . '.jpg', array('width' => '200', 'height' => '200')),
				array('controller' => 'ui', 'action' => 'photoDetail'),
				array('escape' => false)	
			);
		 	?>
		</div>
		<div class="gridview-caption">
			<a href="#">duythanh</a> :
			My photo is so nice
		</div>
		<div class="gridview-static">
			<span class="pull-right">
				<span class="gridview-like-btn"></span>
				<span class="gridview-like-count">3</span>
				<span class="gridview-comment-btn"></span>
				<span class="gridview-comment-count">4</span>
			</span>
		</div>
	</div>
<?php endfor ?>
</div>
<?php echo $this->Html->script(array('jquery.masonry.min', 'jquery.imagesloaded'), array('inline' => false)) ?>
<?php echo $this->Html->scriptStart(array('inline' => false)) ?>
//<script>
	$(document).ready(function(){
		$('.timeline-cover-bg div img').imagesLoaded(function(){
			$('.timeline-cover-bg div').masonry({});	
		});
		$('.gridview-image').click(function(e){
			var url = $(this).find('a').attr('href');
			e.preventDefault();
			$().slidebox({
				iframe: true,
				height: 600,
				width: 958,
				href: url
			});
		});
	});
<?php echo $this->Html->scriptEnd() ?>