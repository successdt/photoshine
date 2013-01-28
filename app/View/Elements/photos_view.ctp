<div class="viewmode-btn">
	<div class="viewmode-group">
		<a href="javascript:void(0)" class="viewmode-grid" rel="tooltip" title="Grid view mode"></a>
		<a href="javascript:void(0)" class="viewmode-list active" rel="tooltip" title="List view mode"></a>
		<a href="javascript:void(0)" class="viewmode-map" rel="tooltip" title="Map view mode"></a>
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
			<span class="pull-left time-ago">
				<i class="icon-time icon-black"></i> 3 minutes ago
			</span>
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

<div class="listview-wrapper">
	<?php for ($i = 0; $i < 32; $i++): ?>
		<div class="listview-block">

				
			<div class="listview-img">
				<?php
					echo $this->Html->link(
						$this->Html->image('tmp/tmp' . rand(1, 10) . '.jpg', array('width' => '200', 'height' => '200')),
						array('controller' => 'ui', 'action' => 'photoDetail'),
						array('escape' => false)
					);
				?>
			</div>
			<div class="listview-sns">
				<a href="javascript:void(0)" class="pull-left photodetail-like-btn btn btn-success">
					<i class="icon-heart icon-white"></i>	
				</a>
				<a href="javascript:void(0)" class="pull-left sns-btn facebook"></a>
				<a href="javascript:void(0)" class="pull-left sns-btn twitter"></a>
				<a href="javascript:void(0)" class="pull-left sns-btn tumblr"></a>
				<a href="javascript:void(0)" class="pull-left sns-btn pinterest"></a>				
			</div>	
			<div class="listview-static">
				<span class="pull-left time-ago">
					<i class="icon-time icon-black"></i> 3 minutes ago
				</span>
				<span class="pull-right">
					<span class="gridview-like-btn"></span>
					<span class="gridview-like-count">3</span>
					<span class="gridview-comment-btn"></span>
					<span class="gridview-comment-count">4</span>
				</span>
			</div>
			<div class="listview-caption">
				<div class="listview-avatar">
					<?php echo $this->Html->link(
						$this->Html->image('photoshine/common_default_avatar.png', array('width' => '30', 'height' => '30')),
						array('controller' => 'u', 'action' => 'successdt'),
						array('escape' => false)
				 	)?>
				</div>
				
				<div class="listview-caption-content">
					<?php echo $this->Html->link('thanhdd', array('controller' => 'Ui', 'action' => 'timeline'), array('class' => 'bold-link')); ?> :
					<br />
					Photocaption
				</div>
				
				<div class="listview-tags">
					<i class="icon-tag icon-black"></i>
					<?php echo $this->Html->link('#hanoi', array('javascript:void(0)')); ?>
					<?php echo $this->Html->link('#travel', array('javascript:void(0)')); ?>
				</div>
				
			</div>
			
			<div class="listview-comment-wrapper">
				<?php for ($j = 0; $j < rand(1, 5); $j++): ?>
					<div class="listview-comment">
						<div class="listview-avatar">
							<?php echo $this->Html->link(
								$this->Html->image('photoshine/common_default_avatar.png', array('width' => '30', 'height' => '30')),
								array('controller' => 'Ui', 'action' => 'timeline'),
								array('escape' => false)
						 	)?>
						</div>
						
						<div class="listview-comment-content">
							<a href="#" class="bold-link">lumia</a> :
							Hello photoshine
							<br />
							welcome to photoshine
							<span class="time-ago" style="display: block;">
								<?php echo $j + 1 ?> minutes ago
							</span>
						</div>
					</div>
				<?php endfor; ?>
			</div>
			
			
		</div>
	<?php endfor; ?>
</div>

<div class="mapview-wrapper">
	<?php echo $this->Html->image('tmp/map_view.png') ?>
</div>

<?php echo $this->Html->script(array('jquery.masonry.min', 'jquery.imagesloaded'), array('inline' => false)) ?>
<?php echo $this->Html->scriptStart(array('inline' => false)) ?>
//<script>
	$(document).ready(function(){

		$('.listview-wrapper').masonry();
		
		$('.gridview-image, .listview-img').click(function(e){
			var url = $(this).find('a').attr('href');
			e.preventDefault();
			$().slidebox({
				iframe: true,
				height: 600,
				width: 958,
				href: url
			});
		});
		$('.viewmode-map').not('.active').click(function(){
			$('.viewmode-group').find('a').removeClass('active');
			$(this).addClass('active');
			$('.mapview-wrapper').show();
			$('.gridview-wrapper, .listview-wrapper').hide();
		});
		
		$('.viewmode-grid').not('.active').click(function(){
			$('.viewmode-group').find('a').removeClass('active');
			$(this).addClass('active');
			$('.gridview-wrapper').show();
			$('.mapview-wrapper, .listview-wrapper').hide();
		});
		
		$('.viewmode-list').click(function(){
			$('.viewmode-group').find('a').removeClass('active');
			$(this).addClass('active');
			$('.listview-wrapper').show().masonry();
			$('.mapview-wrapper, .gridview-wrapper').hide();
		});
	});
<?php echo $this->Html->scriptEnd() ?>