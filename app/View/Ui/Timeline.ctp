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
		<div class="timeline-info-bg"></div>
		<div class="timeline-cover-avatar">
			<?php echo $this->Html->image('photoshine/common_default_avatar.png') ?>
			<div class="timeline-cover-username">thanhdd</div>
		</div>
		<div class="timeline-cover-info">
			<div class="timeline-info-fullname">Duy Thành Đào</div>
			<span>
				<i class="icon-home icon-white"></i>
				Lives in Hanoi, Vietnam
			</span>
			<br />
			<span>
				<i class="icon-globe icon-white"></i>
				<a href="#">www.facebook.com/successdt</a>
			</span>
			<p>
				<i class="icon-user icon-white"></i>
				PHP developer at lifetime technologies
			</p>
		</div>
		
		<div class="cover-user-static">
			<div class="photos-static timeline-stat">
				<div class="timeline-stat-inner">
					<?php
					for ($i = 1; $i <= 2; $i++):
						echo $this->Html->image('tmp/tmp' . rand(1, 10) . '.jpg', array('width' => '50', 'height' => '50'));
					endfor ?>
				</div>
				<div class="timeline-stat-text">
					100 Photos
				</div>
			</div>
			<div class="followers-static timeline-stat">
				<div class="timeline-stat-inner">
					<?php
					for ($i = 1; $i <= 2; $i++):
						echo $this->Html->image('photoshine/common_default_avatar.png', array('width' => '50', 'height' => '50'));
					endfor ?>
				</div>
				<div class="timeline-stat-text">
					20 Followers
				</div>
			</div>
			<div class="following-static timeline-stat">
				<div class="timeline-stat-inner">
					<?php
					for ($i = 1; $i <= 2; $i++):
						echo $this->Html->image('photoshine/common_default_avatar.png', array('width' => '50', 'height' => '50'));
					endfor ?>
				</div>
				<div class="timeline-stat-text">
					5 Following
				</div>
			</div>
		</div>
		
		<div class="cover-btn-group">
			<div class="btn-group pull-right">
				<button class="btn">Follow</button>	  
				<button class="btn dropdown-toggle" data-toggle="dropdown">
			    	<span class="icon-align-justify"></span>
			  	</button>
				<ul class="dropdown-menu">
					<li><a href="#">Report user</a></a></li>
					<li><a href="#">Block user</a></li>
				<!-- dropdown menu links -->
				</ul>
			</div>
	
		</div>
	</div>
</div>

<div class="viewmode-btn">
	<div class="viewmode-group">
		<div class="viewmode-grid"></div>
		<div class="viewmode-list active"></div>
		<div class="viewmode-map"></div>
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
					<?php echo $this->Html->link('thanhdd', array('controller' => 'u', 'action' => 'thanhdd'), array('class' => 'bold-link')); ?> :
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
								array('controller' => 'u', 'action' => 'successdt'),
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
		$('.timeline-cover-bg div img').imagesLoaded(function(){
			$('.timeline-cover-bg div').masonry({});	
		});
		
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
			$('.viewmode-group').find('div').removeClass('active');
			$(this).addClass('active');
			$('.mapview-wrapper').show();
			$('.gridview-wrapper, .listview-wrapper').hide();
		});
		
		$('.viewmode-grid').not('.active').click(function(){
			$('.viewmode-group').find('div').removeClass('active');
			$(this).addClass('active');
			$('.gridview-wrapper').show();
			$('.mapview-wrapper, .listview-wrapper').hide();
		});
		
		$('.viewmode-list').click(function(){
			$('.viewmode-group').find('div').removeClass('active');
			$(this).addClass('active');
			$('.listview-wrapper').show().masonry();
			$('.mapview-wrapper, .gridview-wrapper').hide();
		});
	});
<?php echo $this->Html->scriptEnd() ?>