<?php if(count($activities)) : ?>
	<div class="feed-block listview-block">
			<?php foreach($activities as $activity): ?>
				<?php
				$photoUrl = '';
				if (isset($activity['photo_id']))
					$photoUrl = $this->Html->url(array('controller' => 'photo', 'action' => 'detail', $activity['photo_id']));
			
			 	?>
				<a class="notifications" href="<?php echo $photoUrl ?>">
					<?php
					if (isset($activity['profile_picture']))
							echo $this->Html->image($activity['profile_picture'], array('class' => 'notifications-avatar')); ?>
					<div class="notifications-text">	
						<span>
							<strong><?php echo $activity['from_user'] ?></strong>
							<?php
							if ($activity['type'] == 'like'){
								echo ' likes ';
							}
							if ($activity['type'] == 'comment'){
								echo '  also commented on  ';
							}
						 	?>	
					 		<?php
					 		if ($activity['to_user'] == AuthComponent::user('User.username'))
						 		echo "your ";
					 		else
					 			echo '<strong>' . $activity['to_user'] . "</strong>'s ";
						  	?>
						 	photo
						</span>
						<span class="time-ago" style="display: block;">
							<?php $time = date('Y-m-d H:i:s', $activity['created_time']); ?>
							<abbr class="time-ago" title="<?php echo $time ?>"><?php echo $time ?></abbr>
						</span>
					</div>
					<?php echo $this->Html->image($activity['thumbnail'], array('class' => 'notifications-photo')) ?>
				</a>
			<?php endforeach; ?>
	</div>
	<div class="listview-wrapper" style="margin-left: 310px;">
	
	</div>	
<?php else : ?>		
	<div class="feed-hint" style="margin: 5px;">
		<?php echo $this->Html->image('help/search_hint.png') ?>
		<?php echo $this->Html->image('help/find_friends_click.png') ?>
		<?php echo $this->Html->image('help/find_fb_friend.png') ?>
		<?php echo $this->Html->image('help/start_following.png') ?>
	</div>
	<div style="width: 100%;">
		<div style="width: 335px; margin: 0 auto; padding: 5px 10px; border-radius: 5px;" class="btn-success">
			<h1>Popular photos and suggest users</h1>
		</div>
	</div>
	<div class="listview-wrapper">

	</div>	
<?php endif; ?>



<script type="text/template" id="list-template">
	<% var root = '<?php echo $this->webroot ?>'; %>
	<div class="listview-block data-div photo_<%= photo.id %>" data-id="<%= photo.id %>">
		<div class="listview-img" style="width: 200px; height: 200px;">
		 	<a href="<%= root + 'photo/detail/' + photo.id %>">
			 	<img src="<%= root + 'img/' + photo.low_resolution_url %>" width="200" height="200" />
			 </a>
		</div>
		<div class="listview-sns">
			<a href="javascript:void(0)" class="pull-left photodetail-like-btn btn btn-success <%= photo.user_had_liked ? 'active' : '' %>">
				<i class="icon-heart icon-white"></i>	
			</a>
			<a href="javascript:share('facebook', '<%= photo.thumbnail %>', '<%= photo.id %>', '<%= photo.caption %>')" class="pull-left sns-btn facebook"></a>
			<a href="javascript:share('twitter', '<%= photo.thumbnail %>', '<%= photo.id %>', '<%= photo.caption %>')" class="pull-left sns-btn twitter"></a>
			<a href="javascript:share('tumblr', '<%= photo.thumbnail %>', '<%= photo.id %>', '<%= photo.caption %>')" class="pull-left sns-btn tumblr"></a>
			<a href="javascript:share('pinterest', '<%= photo.thumbnail %>', '<%= photo.id %>', '<%= photo.caption %>')" class="pull-left sns-btn pinterest"></a>			
		</div>	
		<div class="listview-static">
			<span class="pull-left time-ago">
				<i class="icon-time icon-black"></i>
				<abbr class="time-ago" title="<%= photo.created_time %>"><%= photo.created_time %></abbr>
			</span>
			<span class="pull-right">
				<span class="gridview-like-btn <%= photo.user_had_liked ? 'active' : '' %>"></span>
				<span class="gridview-like-count"><%= photo.like_count %></span>
				<span class="gridview-comment-btn"></span>
				<span class="gridview-comment-count"><%= photo.comment_count %></span>
			</span>
		</div>
		<div class="listview-caption">
			<div class="listview-avatar">
			 	<a href="<%= root + 'u/' + photo.User.username %>">
				 	<img src="<%= root + 'img/' + photo.User.profile_picture %>" width="40" height="40" alt="<%= photo.User.username %>" />
				</a>
			</div>
			
			<div class="listview-caption-content">
				<a href="<%= root + 'u/' + photo.User.username %>" class="bold-link"><%= photo.User.username %></a> :
				<br />
				<%= photo.caption ? text2link(photo.caption, root) : '' %>
				<br />
			</div>
			
			<div class="listview-tags">
				<i class="icon-tag icon-black"></i>
				<%
					var tag1 = '';
					var tag2 = '';
					if(photo.tags){
						var tags = photo.tags.split(',');
						tag1 = tags[0];
						tag2 = tags[1];
					}
				%>
				<%= text2link(tag1, root) %>
				<%= text2link(tag2, root) %>
			</div>
			
		</div>
		<% if(photo.comment_count > 5){ %>
		<div class = "view-all" style="text-align:center;">
			<a href="<%= root + 'photo/detail/' + photo.id + '/popup' %>">View all <span data-count="<%=photo.comment_count %>"><%=photo.comment_count %></span> comments</a>
		</div>
					
		<%}%>
		<div class="listview-comment-wrapper">
			<% var len = _.size(photo.Comment);
			%>
			<% if (len == 1){ %>
				<div class="listview-comment">
					<div class="listview-avatar">
					 	<a href="<%= root + 'u/' + photo.Comment[0].User.username %>">
						 	<img src="<%= root + 'img/' + photo.Comment[0].User.profile_picture %>" width="30" height="30" alt="<%= photo.Comment[0].User.username %>" />
						</a>
					</div>
					
					<div class="listview-comment-content">
						<a href="<%= root + 'u/' + photo.Comment[0].User.username %>" class="bold-link"><%= photo.Comment[0].User.username %></a> :
						<%= text2link(photo.Comment[0].Comment.text, root) %>
						<span class="time-ago" style="display: block;">
							<abbr class="time-ago" title="<%= photo.Comment[0].Comment.created_time %>"><%= photo.Comment[0].Comment.created_time %></abbr>
						</span>
					</div>
				</div>			
			<% }
			else { %>
				<% for (var i = len - 1; i >= 0; i--){ %>
					<div class="listview-comment">
						<div class="listview-avatar">
						 	<a href="<%= root + 'u/' + photo.Comment[i].User.username %>">
							 	<img src="<%= root + 'img/' + photo.Comment[i].User.profile_picture %>" width="30" height="30" alt="<%= photo.Comment[i].User.username %>" />
							</a>
						</div>
						
						<div class="listview-comment-content">
							<a href="<%= root + 'u/' + photo.Comment[i].User.username %>" class="bold-link"><%= photo.Comment[i].User.username %></a> :
							<%= text2link(photo.Comment[i].Comment.text, root) %>
							<span class="time-ago" style="display: block;">
								<abbr class="time-ago" title="<%= photo.Comment[i].Comment.created_time %>"><%= photo.Comment[i].Comment.created_time %></abbr>
							</span>
						</div>
					</div>
				<% } %>
			<% } %>
		</div>
		
		
	</div>
</script>
<script type="text/template" id="user-result">
	<% var root = '<?php echo $this->webroot ?>'; %>
	<div class="listview-block  user-result">
		<a href="<%= root + 'u/' + user.username %>">
			<div class="margin10 result-avatar">
				<img src="<%= root + 'img/' + user.profile_picture %>" alt="<%= user.username %>" />
			</div>
			<div class="result-name">
				<span class="ellipsis">
					<h5><%= user.username %></h5>
				</span>
				<span class="ellipsis">
					<h6><%= user.first_name ? user.first_name : '' + ' ' + user.last_name ? user.last_name : '' %></h6>
				</span>
			</div>
		</a>
	</div>
</script>

<?php echo $this->Html->script(array('jquery.masonry.min', 'jquery.imagesloaded'), array('inline' => false)) ?>
<?php echo $this->Html->scriptStart(array('inline' => false)) ?>
//<script>
	$(document).ready(function(){
		feedCallback();
		$(window).resize(function(){
			feedCallback();
		});
		$('.listview-wrapper').masonry();
	});
	
	function feedCallback(){
		$('.feed-block').height($(window).height() - 38);
		$('.feed-block').jScrollPane();		
	}
<?php echo $this->Html->scriptEnd() ?>
<?php echo $this->Html->script(array('jquery.masonry.min', 'autobrowse', 'underscore.min', 'jquery.textreplace', 'jquery.timeago'), array('inline' => false)) ?>
<?php echo $this->Html->scriptStart(array('inline' => false)) ;?>
//<script>
	var root = '<?php echo $this->webroot ?>';
	var page = 0;

	
	$(document).ready(function(){
		
		
		$('.listview-img a, a.notifications').live('click', function(e){
			var url = $(this).attr('href') + '/popup';
			e.preventDefault();
			$().slidebox({
				iframe: true,
				height: 600,
				width: 958,
				href: url
			});
		});

		
		$('.loading').show();
		loadPhotos();
		
		$(window).scroll(function(){     
			if(($(window).scrollTop() + $(window).height() > ($(document).height() - 400)) && loadingLock)
			{
				$('.loading').show();
				loadingLock = false;
				loadPhotos();
			}
		});
		

		//like photo process
		$('.gridview-like-btn').live('click', function(){
			var outter = $(this).closest('.data-div');
			var photoId = $(outter).data('id');
			var likeCount =  parseInt($(outter).find('.gridview-like-count').html());
			
			if ($(this).hasClass('active')){
				url =  root + 'ajax/callApi/unlikePhoto';
				$('.photo_' + photoId + ' .gridview-like-count').html(likeCount - 1);
				$('.photo_' + photoId).find('.gridview-like-btn').removeClass('active');
			}
			else{
				url = root + 'ajax/callApi/likePhoto';
				$('.photo_' + photoId + ' .gridview-like-count').html(likeCount + 1);
				$('.photo_' + photoId).find('.gridview-like-btn').addClass('active');
			}
			$('.loading').show();
			
			$.ajax({
				url : url,
				type : 'POST',
				data : {'id' : photoId},
				complete : function(response){
					var result = $.parseJSON(response.responseText);
					$('.loading').hide();
					if (!result.meta.success){
						
					}
				}
			});		
		});

		setInterval(function(){
			$('abbr.time-ago').timeago();
		}, 10000);
		
		
	});
	
	//load photo from ajax request
	function loadPhotos(){
		$('.loading').show();
		$.ajax({
			url : root + 'ajax/callApi/getListPhotoFeed',
			type : 'POST',
			data : { page : page},
			complete : function (response){
				var result = $.parseJSON(response.responseText);
				$('.loading').hide();
				loadingLock = true;
				page = result.meta.next_page;
				if (!page){
					loadingLock = false;
					loadSuggest();
				}
				
				for (var i = 0; i < result.data.length; i++){
					
					var listTemplate = _.template(
				     	$( "#list-template" ).html()
				    );
					var listMarkup = listTemplate({photo : result.data[i]});
					$('.listview-wrapper').append(listMarkup);				
				}
				callback();
			}
		});		
	}
	
	function callback(){
		setTimeout(function(){
			$('.listview-wrapper').masonry();
			$('.listview-wrapper').masonry('reload');	
		}, 200);
		
		$('abbr.time-ago').timeago();
	}
	
	function loadSuggest(){
		$('.loading').show();
		$.ajax({
			url : root + 'ajax/callApi/suggest',
			type : 'POST',
			data : { 'page' : 0},
			complete : function (response){
				var result = $.parseJSON(response.responseText);
				$('.loading').hide();
				for (var i = 0; i < result.data.Photo.length; i++){
					
					var listTemplate = _.template(
				     	$( "#list-template" ).html()
				    );
					var listMarkup = listTemplate({photo : result.data.Photo[i]});
					$('.listview-wrapper').append(listMarkup);				
				}
				for (var i = 0; i < result.data.User.length; i++){
					var userTemplate = _.template(
				     	$( "#user-result" ).html()
				    );
					var listMarkup = userTemplate({user : result.data.User[i].User});
					$('.listview-wrapper').append(listMarkup);								
				}
				callback();
			}
		});			
	}
	
	
	
<?php echo $this->Html->scriptEnd() ?>
<?php echo $this->element('share_link') ?>