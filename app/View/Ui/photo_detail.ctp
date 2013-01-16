<div class="photodetail-wrapper">
	<div class="photodetail-photo">
		<?php echo $this->Html->image('tmp/tmp3_hi.jpg', array('width' => '600', 'height' => '600')) ?>
	</div>
	<div class="photodetail-caption">
			<div class="detail-avatar">
				<?php echo $this->Html->link(
					$this->Html->image('photoshine/common_default_avatar.png', array('width' => '40', 'height' => '40')),
					array('controller' => 'u', 'action' => 'successdt'),
					array('escape' => false)
			 	)?>
			</div>
			<div class="photodetail-caption-inner">
				<b>
					<?php echo $this->Html->link('successdt', array('controller' => 'u', 'action' => 'successdt'), array('class' => 'author'));?> :
				</b>
				This is a photo caption<br />
				This is a caption
			</div>
	</div>
	<div class="photodetail-sns">
		<!-- AddThis Button BEGIN -->
		<div class="addthis_toolbox addthis_default_style addthis_32x32_style">
			<a href="javascript:void(0)" class="pull-left photodetail-like-btn btn btn-success">
				<i class="icon-heart icon-white"></i>	
			</a>
			<a class="addthis_button_preferred_1"></a>
			<a class="addthis_button_preferred_2"></a>
			<a class="addthis_button_preferred_3"></a>
			<a class="addthis_button_preferred_4"></a>
			<!-- <a class="addthis_button_compact"></a> -->
			<!-- <a class="addthis_bubble_style"></a> -->
		</div>
		<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=xa-50f60ca71c9ac2d2"></script>
		<!-- AddThis Button END -->
	</div>
	<div class="photodetail-list-like">
			<span class="photodetail-like-count">3</span> Likes <br />
		Liked by: 
		<b>
			<a href="#">@phuongnh</a>
			<a href="#">@thanhdd</a>
			<a href="#">@user</a>		
		</b>

		

	</div>
	<div class="photodetail-list-comment">
		<div class="photodetail-view-all">
			<a href="javascript:void(0)">View all 10 comments</a>
		</div>
		<?php for ($i = 0; $i < 10; $i++): ?>
		<div class="photodetail-comment-container">

			<div class="photodetail-avatar">
				<?php echo $this->Html->link(
					$this->Html->image('photoshine/common_default_avatar.png', array('width' => '40', 'height' => '40')),
					array('controller' => 'u', 'action' => 'successdt'),
					array('escape' => false)
			 	)?>
			</div>
			<div class="photodetail-caption-inner">
				<b>
					<?php echo $this->Html->link('successdt', array('controller' => 'u', 'action' => 'successdt'), array('class' => 'author'));?> :
				</b>
				This is comment <?php echo $i ?>
			</div>
			<div class="photodetail-comment-time time-ago">
				<span class="pull-right">5 hours ago</span>
			</div>
		</div>
		<?php endfor ?>
	</div>
	<div class="photodetail-post-comment">
		<textarea class="post-comment"></textarea>
	</div>
</div>