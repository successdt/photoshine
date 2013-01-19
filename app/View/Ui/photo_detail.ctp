<?php echo $this->Html->css(array('jquery.jscrollpane')) ?>
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
		<a href="javascript:void(0)" class="pull-left photodetail-like-btn btn btn-success">
			<i class="icon-heart icon-white"></i>	
		</a>
		<a href="javascript:void(0)" class="pull-left sns-btn facebook"></a>
		<a href="javascript:void(0)" class="pull-left sns-btn twitter"></a>
		<a href="javascript:void(0)" class="pull-left sns-btn tumblr"></a>
		<a href="javascript:void(0)" class="pull-left sns-btn pinterest"></a>
	</div>
	<div class="photodetail-list-like">
		<span><span class="photodetail-like-count">3</span> Likes</span> <br />
		<span>Liked by:</span> 
		<b>
			<a href="#">@phuongnh</a>
			<a href="#">@thanhdd</a>
			<a href="#">@user</a>	
		</b>
	</div>		
	<div class="photodetail-view-all">
		<a href="javascript:void(0)">View all 10 comments</a>
	</div>
	<div class="photodetail-list-comment">
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
	
		<?php echo $this->Html->link(
			$this->Html->image('photoshine/common_default_avatar.png', array('width' => '60', 'height' => '60')),
			array('controller' => 'u', 'action' => 'successdt'),
			array('escape' => false, 'class' => 'pull-left')
	 	)?>
		<textarea class="post-comment" placeholder="Write a comment..."></textarea>
	</div>
</div>
<?php echo $this->Html->script(array('jquery.jscrollpane.min', 'jquery.mousewheel'), array('inline' => false)) ?>
<?php echo $this->Html->scriptStart(array('inline' => false)) ?>
//<script>
 $(document).ready(function(){	
	$('.photodetail-list-like, .photodetail-list-comment').jScrollPane();
});

<?php echo $this->Html->scriptEnd() ?>