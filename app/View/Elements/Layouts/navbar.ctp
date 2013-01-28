<?php echo $this->Html->css(array('jquery.jscrollpane')) ?>
<div class="navbar-inner">
    <div class="container">

        <ul class="nav">
            <li class="active">
            	<?php echo $this->Html->link(
            		$this->Html->image('photoshine/photoshine 100x100.png', array('width' => '24', 'height' => '24')) . ' PhotoShine',
            		array('controller' => 'photoshine'),
            		array('class' => 'brand', 'escape' => false)
				); ?>
            </li>
            <li class="divider-vertical"/>
            <li>
            	
				<div class="btn-group">
					<a href="javascript:void(0)" class="btn navbar-channels" rel="tooltip" title="Channels">
						<i class="icon-th icon-black"></i>
					</a>
					<a href="<?php echo $this->Html->url(array('controller' => 'Ui', 'action' => 'nearby')) ?>" class="btn" rel="tooltip" title="Nearby">
						<i class="icon-map-marker icon-black"></i>
					</a>
					<a href="<?php echo $this->Html->url(array('controller' => 'Ui', 'action' => 'popular')) ?>" class="btn" rel="tooltip" title="Popular">
						<i class="icon-star icon-black"></i>
					</a>
					<a href="<?php echo $this->Html->url(array('controller' => 'Ui', 'action' => 'myLikes')) ?>" class="btn" rel="tooltip" title="My likes">
						<i class="icon-thumbs-up icon-black"></i>
					</a>
					<a href="<?php echo $this->Html->url(array('controller' => 'Ui', 'action' => 'upload')) ?>" class="btn" rel="tooltip" title="Upload">
						<i class="icon-camera icon-black"></i>
					</a>
					<a href="javascript:void(0)" class="btn navbar-nf" rel="tooltip" title="Notifications">
						<i class="icon-globe icon-black"></i>
					</a>
					
			<li class="divider-vertical"/>            
            <li>
                <form class="navbar-form pull-left" action="<?php echo $this->Html->url(array('controller' => 'Ui', 'action' => 'searchResult')) ?>">
                  <input type="text" class="span3" autocomplete="off" placeholder="Search for tags or users" style="padding-right: 44px;">
                  <button type="submit" class="btn search-submit"><i class="icon-search icon-black"></i></button>
                </form>
            <div id="suggestions" style="display: none;"></div>
            </li>
        </ul>
    	<ul class="pull-right nav">
    		<li class="dropdown btn-group">
				<button class="btn">thanhdd</button>
				<button class="btn dropdown-toggle" data-toggle="dropdown">
					<span class="icon-align-justify"></span>
				</button>
				<ul class="dropdown-menu">
	            	<li><a href="<?php echo $this->Html->url(array('controller' => 'Ui', 'action' => 'settings')) ?>">Edit Profile</a></li>
	            	<li><a href="<?php echo $this->Html->url(array('controller' => 'Ui', 'action' => 'findFriends')) ?>">Find Friends</a></li>
	            	<li><a href="<?php echo $this->Html->url(array('controller' => 'Ui', 'action' => 'servicesMan')) ?>">Link Other Services</a></li>
	            	<li><a href="<?php echo $this->Html->url(array('controller' => 'Ui', 'action' => 'privacy')) ?>">Privacy Settings</a></li>
	            	<li><a href="<?php echo $this->Html->url(array('controller' => 'Ui', 'action' => 'feedback')) ?>" class="nav-feedback">Feed back</a></li>
	            	<li><a href="<?php echo $this->Html->url(array('controller' => 'Ui', 'action' => 'help')) ?>">Help</a></li>
	            	<li><a href="#">Logout</a></li>
	            </ul>			
			</li>
		</ul>
    </div><!-- /container -->
</div><!--/navbar-inner  -->

<div class="channel-menu-html" style="display: none;">
	<div class="channel-menu">
		<?php
		$listChannels = array(
			array('class' => 'featured', 'text' => 'Featured User'),	
			array('class' => 'brands', 'text' => 'Brands'),
			array('class' => 'celebrities', 'text' => 'Celebrities'),
			array('class' => 'fashion', 'text' => 'Fashion'),
			array('class' => 'food', 'text' => 'Food'),
			array('class' => 'travel', 'text' => 'Travel'),
			array('class' => 'animals', 'text' => 'Animals'),
			array('class' => 'sports', 'text' => 'Sport'),
			array('class' => 'music', 'text' => 'Music'),
			array('class' => 'architecture', 'text' => 'Architecture'),
			array('class' => 'design', 'text' => 'Art/Design'),
			array('class' => 'tech', 'text' => 'Tech'),
		);
		?>
		<?php foreach ($listChannels as $channel): ?>
			<a class="tag" href="<?php echo $this->Html->url(array('controller' => 'ui', 'action' => 'channel', $channel['class'])) ?>">
				<i class="tag-<?php echo $channel['class'] ?>-icn tag-icn pull-left"></i>
				<span class="pull-left"></span><?php echo $channel['text'] ?>
			</a>
		<?php endforeach; ?>

	</div>
</div>

<div class="nf-popup">
	<div class="up-arrow"></div>
	<div class="nf-container">
		<div class="nf-header btn-success">
			Notifications
		</div>
		<div class="nf-content" id="nf-content">
			<?php for ($i = 0; $i < 8; $i++): ?>
				<a class="notifications" href="#">
					<?php echo $this->Html->image('photoshine/common_default_avatar.png', array('class' => 'notifications-avatar')); ?>
					<div class="notifications-text">
						<strong>phuongnh</strong> likes your photo
					</div>
					<?php echo $this->Html->image('tmp/tmp' . rand(1, 10) . '.jpg', array('class' => 'notifications-photo')) ?>
				</a>
				<a class="notifications" href="#">
					<?php echo $this->Html->image('photoshine/common_default_avatar.png', array('class' => 'notifications-avatar')); ?>
					<div class="notifications-text">
						<strong>phuongnh</strong> also commented on your photo
					</div>
					<?php echo $this->Html->image('tmp/tmp' . rand(1, 10) . '.jpg', array('class' => 'notifications-photo')) ?>
				</a>
				<a class="notifications" href="#">
					<?php echo $this->Html->image('photoshine/common_default_avatar.png', array('class' => 'notifications-avatar')); ?>
					<div class="notifications-text">
						<strong>phuongnh</strong> mentioned your in a comment
					</div>
					<?php echo $this->Html->image('tmp/tmp' . rand(1, 10) . '.jpg', array('class' => 'notifications-photo')) ?>
				</a>
			<?php endfor; ?>
		</div>
		<div class="nf-footer btn-success">
			<a href="#" style="color: #FFF;">See All</a>
		</div>
	</div>
</div>
<?php echo $this->Html->script(array('jquery.jscrollpane.min', 'jquery.mousewheel'), array('inline' => false)) ?>

<script type="text/template" id="feedback-template">
<div style="width: 750px; height: 393px">
	<div class="edit-profile" style="margin: 0px !important;">
		<div class="edit-profile-header btn-success">Help Improve PhotoShine.</div>
		<div class="edit-profile-body">
			<hr />
			<textarea class="feedback-text" style="width: 715px; height: 140px;"></textarea>
			<hr />
			<div class="row-fluid">
				<div class="span6">
					<button class="pull-right btn btn-success">Send</button>
				</div>
				<div class="span6">
					<button class="pull-left btn btn-danger">Clear</button>
				</div>
			</div>
		</div>
		<div class="edit-profile-footer btn-success"></div>
	</div>
</div>
</script>
<?php echo $this->Html->scriptStart(array('inline' => false)) ?>
//<script>
	
	$(document).ready(function(){
		$('.navbar-inner a').tooltip({
			placement : 'bottom'
		});
		$('.navbar-channels').click(function(){
			var html = $('.channel-menu-html').html();
			
			$().slidebox({
				html: html
			});
		});
		
		$('.navbar-nf').click(function(e){
			e.stopPropagation();
			var left = $(this).offset().left + 8;
			
			$('.nf-popup').css('left', left);
			$('.nf-popup').show();
			$('.nf-content').jScrollPane();
		});
		$('.nf-header, .nf-content').click(function(e){
			e.stopPropagation();
		});
		$(document).click(function(){
			$('.nf-popup').hide();
		});
		
		$('.nav-feedback').click(function(e){
			e.preventDefault();
			var html = $('#feedback-template').html();
			$().slidebox({
				html: html,
			});
		});
		
	});
<?php echo $this->Html->scriptEnd() ?>