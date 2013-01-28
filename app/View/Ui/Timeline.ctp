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