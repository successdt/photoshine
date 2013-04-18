<?php echo $this->Html->css(array('jquery.jscrollpane')) ?>
<div class="navbar-inner">
    <div class="container">

        <ul class="nav">
            <li class="active">
            	<?php echo $this->Html->link(
            		$this->Html->image('photoshine/photoshine 100x100.png', array('width' => '24', 'height' => '24')) . ' PhotoShine',
            		array('controller' => 'home', 'action' => 'feed'),
            		array('class' => 'brand', 'escape' => false)
				); ?>
            </li>
            <li class="divider-vertical"/>
            <li>
            	
				<div class="btn-group">
					<a href="javascript:void(0)" class="btn navbar-channels" rel="tooltip" title="Channels">
						<i class="icon-th icon-black"></i>
					</a>
					<a href="javascript:void(0)" onclick="javascript:getLocation()" class="btn" rel="tooltip" title="Nearby">
						<i class="icon-map-marker icon-black"></i>
					</a>
					<a href="<?php echo $this->Html->url(array('controller' => 'photo', 'action' => 'popular')) ?>" class="btn" rel="tooltip" title="Popular">
						<i class="icon-star icon-black"></i>
					</a>
					<a href="<?php echo $this->Html->url(array('controller' => 'photo', 'action' => 'myLikes')) ?>" class="btn" rel="tooltip" title="My likes">
						<i class="icon-thumbs-up icon-black"></i>
					</a>
					<a href="javascript:void(0)" class="btn upload-btn" rel="tooltip" title="Upload">
						<i class="icon-camera icon-black"></i>
					</a>
					<a href="javascript:void(0)" class="btn navbar-nf" rel="tooltip" title="Notifications">
						<span></span>
						<i class="icon-globe icon-black"></i>
					</a>
					
			<li class="divider-vertical"/>            
            <li>
                <form class="navbar-form pull-left" method="GET" action="<?php echo $this->Html->url(array('controller' => 'home', 'action' => 'search')) ?>">
                  <input type="text" class="span3" name="q" autocomplete="off" placeholder="Search for tags or users" style="padding-right: 44px;">
                  <button type="submit" class="btn search-submit"><i class="icon-search icon-black"></i></button>
                </form>
            <div id="suggestions" style="display: none;"></div>
            </li>
        </ul>
    	<ul class="pull-right nav">
    		<li class="dropdown btn-group">
				<button class="btn" onclick="javascript:goto('<?php echo $this->Html->url(array('controller' => 'u', 'action' => AuthComponent::user('User.username'))); ?>')">
					<?php echo AuthComponent::user('User.username') ?>
				</button>				
				<button class="btn dropdown-toggle" data-toggle="dropdown">
					<span class="icon-align-justify"></span>
				</button>
				<ul class="dropdown-menu">
	            	<li><a href="<?php echo $this->Html->url(array('controller' => 'user', 'action' => 'editProfile')) ?>">Edit Profile</a></li>
	            	<li><a href="<?php echo $this->Html->url(array('controller' => 'user', 'action' => 'findFriends')) ?>">Find Friends</a></li>
	            	<li><a href="<?php echo $this->Html->url(array('controller' => 'user', 'action' => 'servicesMan')) ?>">Link Other Services</a></li>
	            	<li><a href="<?php echo $this->Html->url(array('controller' => 'user', 'action' => 'privacy')) ?>">Privacy Settings</a></li>
	            	<li><a href="<?php echo $this->Html->url(array('controller' => 'user', 'action' => 'feedback')) ?>" class="nav-feedback">Feed back</a></li>
	            	<li><a href="<?php echo $this->Html->url(array('controller' => 'user', 'action' => 'help')) ?>">Help</a></li>
	            	<li>
						<?php echo $this->Html->link('Logout', array('controller' => 'Account', 'action' => 'logout')) ?>
					</li>
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
			<a class="tag" href="<?php echo $this->Html->url(array('controller' => 'photo', 'action' => 'channel', $channel['class'])) ?>">
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
		</div>
		<div class="nf-footer btn-success">
			<a href="javascript:loadMoreNf()" style="color: #FFF;">See more</a>
		</div>
	</div>
</div>
<?php echo $this->Html->script(array('jquery.jscrollpane.min', 'jquery.mousewheel', 'underscore.min'), array('inline' => false)) ?>

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
<script type="text/template" id="notification-template">
<% var root = '<?php echo $this->webroot ?>'%>
<a class="notifications <%= noti.user_had_read ? '' : 'unread' %> top-nf top-nf<%=noti.id%>" href="<%= root + 'photo/detail/' + photo.id%>" target="_blank" onclick="readNf(<%= noti.id %>);">
	<img class="notifications-avatar" src="<%= root + 'img/' + user.profile_picture %>"/>
	<div class="notifications-text">
		<strong><%= user.username %></strong> 
		<% if(noti.type == 1){ %>
		likes your photo
		<% } %>
		<% if(noti.type == 2){ %>
		also commented on your photo
		<% } %>
		<% if(noti.type == 3){ %>
		mentioned your in a comment
		<% } %>
	</div>
	<img class="notifications-photo" src="<%= root + 'img/' + photo.thumbnail %>"/>
</a>
</script>
<?php echo $this->Html->scriptStart(array('inline' => false)) ?>
//<script>	
	var root = '<?php echo $this->webroot ?>';
	var nfPage = 0;
	
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
			
		});
		$('.navbar-nf').one('click', function(){
			loadNotification();
//			$('.nf-content').jScrollPane();
		});

		$('.nf-header, .nf-content, .nf-footer').click(function(e){
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
		
		$('.upload-btn').click(function(){
			$().slidebox({
				href: '<?php echo $this->Html->url(array('controller' => 'Upload', 'action' => 'start')) ?>',
				iframe: true,
				height: 75,
				width: 960
			});
		});
		
		$.ajax({
			url : '<?php echo $this->Html->url(array('controller' => 'ajax', 'action' => 'callApi', 'getUnreadNotiCount')) ?>',
			type : 'POST',
			data : ({'id' : 0}),
			complete : function (response){
				var result = $.parseJSON(response.responseText);
				var count = result.data;
				if(count){
					$('.navbar-nf i').hide();
					$('.navbar-nf span').html(count);
					$('title').prepend('(' + count + ') ');
				}
			}
		});	
	});
	
	function goto(url){
		window.location = url;
	}
	function getLocation(){
		if (navigator.geolocation){
			navigator.geolocation.getCurrentPosition(showPosition);
		}
		else{
			x.innerHTML="Geolocation is not supported by this browser.";
		}
	}
	function showPosition(position){
		var url = '<?php echo $this->Html->url(array('controller' => 'location', 'action' => 'nearby')) ?>/' + position.coords.latitude + '/' + position.coords.longitude;
		goto(url);
	}
	
	//load notification from ajax request
	function loadNotification(){
		$('.loading').show();
		$.ajax({
			url : '<?php echo $this->Html->url(array('controller' => 'ajax', 'action' => 'callApi', 'getNotification')) ?>',
			type : 'POST',
			data : ({'page' : nfPage}),
			complete : function (response){
				var result = $.parseJSON(response.responseText);
				$('.loading').hide();
				nfLoadingLock = true;
				nfPage = result.meta.next_page;
				if (!nfPage){
					nfLoadingLock = false;
					$('.nf-footer a').remove();
				}
				
				for (var i = 0; i < result.data.length; i++){
					var template = _.template(
				     	$( "#notification-template" ).html()
				    );
					var markup = template({photo : result.data[i].Photo, user : result.data[i].User, noti : result.data[i].Notification});
					
					
					if(nfPage < 2){
						$('#nf-content').append(markup);
					}
					else{
//						$('#nf-content').append(markup);
						var nfPane = $('#nf-content');
						nfPane.jScrollPane();
						var nfApi = nfPane.data('jsp');
						nfApi.getContentPane().append(markup);
						nfApi.reinitialise();						
					}
					
				}
				if (nfPage < 2){
					$('#nf-content').jScrollPane();
				}
				
			}
		});		
	}
	function loadMoreNf(){
		$('.loading').show();
		nfLoadingLock = false;
		loadNotification();
	}
	function readNf(id){
		$('.top-nf' + id).removeClass('unread');
		//giam bot so notification
		var count = parseInt($('.navbar-nf span').html());
		var title = $('title').html();
		if(count > 1){
			count--;
			$('.navbar-nf span').html(count);
			title = title.replace('(' + (count + 1) + ')', '(' + count + ')');
			$('title').html(title);
		}
		else{
			$('.navbar-nf span').hide();
			$('.navbar-nf i').show();
			title = title.replace('(' + count + ')', '');
			$('title').html(title);
		}
		$.ajax({
			url : '<?php echo $this->Html->url(array('controller' => 'ajax', 'action' => 'callApi', 'readNotification')) ?>',
			type : 'POST',
			data : ({'id' : id}),
			complete : function (response){
			}
		});	
	}
<?php echo $this->Html->scriptEnd() ?>