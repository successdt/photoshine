<?php
if(!isset($data['Photo']) || !$data['Photo'])
	die;
$data['like_count'] = count($data['Like']);
$data['Photo']['tags'] = explode(',', $data['Photo']['tags']);
$likeBtn = $data['Photo']['user_had_liked'] ? 'active' : '';

?>

<?php echo $this->Html->css(array('jquery.jscrollpane')) ?>
<div class="photodetail-wrapper">
	<div class="photodetail-photo">

		<div class="photodetail-group">
			<div class="photodetail-photo-inner photo" >
				<?php echo $this->Html->image($data['Photo']['standard_resolution'], array('width' => '600', 'height' => '600')) ?>
			</div>				
		</div>
		<div class="photodetail-photo-inner option" style="display: none;">
			<div class="row-fluid">
				<?php
					$sns = array('fb' => 'facebook','tw' => 'twitter','tb' => 'tumblr','fl' => 'flickr');
					foreach ($sns as $key => $value):
						if (isset($token[$value . '_token']) && $token[$value . '_token']):

	
 				?>
					<div class="span3"><div class="set-sns-btn on <?php echo $key . ' ' . $value ?> active" data-name="<?php echo $value ?>"></div></div>
				<?php else: ?>
					<div class="span3"><div class="set-sns-btn <?php echo $key . ' ' . $value ?>" data-name="<?php echo $value ?>"></div></div>
				<?php
						endif;
					endforeach
				?>
			</div>
			<hr />
			<textarea class="feedback-text" style="width: 585px; height: 130px;" placeholder="Share photo caption..."><?php echo h($data['Photo']['caption']) ?></textarea>
			<div class="row-fluid" >
				<div class="span6">
					<button class="pull-right btn btn-success share-submit">Send</button>
				</div>
				<div class="span6">
					<button class="pull-left btn btn-danger">Cancel</button>
				</div>
				<hr />
				<div class="row-fluid">
					<div class="span6">
						<?php echo $this->element('mini_map', array(
							'latitude'=> $data['Photo']['Location']['latitude'],
							'longitude' => $data['Photo']['Location']['longitude']));
						?>
					</div>
					<div class="span6">
						<textarea class="report-text" style="width: 280px; height: 250px;" placeholder="Report reason..."></textarea>
						<button style="margin-left: 72px;" class="btn btn-danger pull-left">Report this photo</button>
					</div>
				</div>
			</div>
		</div>

	</div>
	<div class="photodetail-caption">
			<div class="detail-avatar">
				<?php echo $this->Html->link(
					$this->Html->image($data['Photo']['User']['profile_picture'], array('width' => '40', 'height' => '40')),
					array('controller' => 'u', 'action' => $data['Photo']['User']['username']),
					array('escape' => false)
			 	)?>
			</div>
			<div class="photodetail-caption-inner">
				<div>
					<b>
						<?php echo $this->Html->link($data['Photo']['User']['username'], array('controller' => 'u', 'action' => $data['Photo']['User']['username']), array('class' => 'author'));?> :
					</b>				
				</div>
				<div>
					<abbr class="time-ago" title="<?php echo $data['Photo']['created_time'] ?>"><?php echo $data['Photo']['created_time'] ?></abbr>
				</div>
				<div class="detail-caption">
					<?php echo h($data['Photo']['caption']) ?>
					<?php
						if (isset($data['Photo']['tags'][0])){
							echo ' ' . $data['Photo']['tags'][0];
						}
						
						if (isset($data['Photo']['tags'][1])){
							echo ' ' . $data['Photo']['tags'][1];
						}
				 	?>				
				
				</div>

			 	
			</div>
	</div>
	<div class="photodetail-sns">
		<a href="javascript:void(0)" class="pull-left photodetail-like-btn btn btn-success <?php echo $likeBtn ?>">
			<i class="icon-heart icon-white"></i>	
		</a>
		<a href="javascript:void(0)" class="pull-left sns-btn facebook"></a>
		<a href="javascript:void(0)" class="pull-left sns-btn twitter"></a>
		<a href="javascript:void(0)" class="pull-left sns-btn tumblr"></a>
		<a href="javascript:void(0)" class="pull-left sns-btn pinterest"></a>
		<a href="javascript:void(0)" class="pull-left btn more-opt">
			<i class="icon-align-justify"></i>
		</a>
	</div>
	<div class="photodetail-list-like">
		<span><span class="photodetail-like-count"><?php echo $data['like_count'] ?></span> Likes</span> <br />
			<span>Liked by:</span> 
			<b class="liked-user">
				<?php
				foreach ($data['Like'] as $like):
					echo $this->Html->link($like['User']['username'],
						array(
							'controller' => 'u',
							'action' => $like['User']['username']
						),
						array(
							'class' => $like['User']['username'] . '-liked'
						)
					);
				endforeach; ?>	
			</b>
			
	</div>		
	<div class="photodetail-view-all">
		<?php if($data['comment_count'] > 5): ?>
			<a href="javascript:void(0)">View all <span data-count="<?php echo $data['comment_count'] ?>"><?php echo $data['comment_count'] ?></span> comments</a>
		<?php endif ?>
	</div>
	<div class="photodetail-list-comment">
		<?php foreach($data['Comment'] as $comment): ?>
			<div class="photodetail-comment-container">
				<div class="photodetail-avatar">
					<?php echo $this->Html->link(
						$this->Html->image($comment['User']['profile_picture'], array('width' => '40', 'height' => '40')),
						array('controller' => 'u', 'action' => $comment['User']['username']),
						array('escape' => false)
				 	)?>
				</div>
				<div class="photodetail-caption-inner">
					<b>
						<?php echo $this->Html->link($comment['User']['username'], array('controller' => 'u', 'action' => $comment['User']['username']), array('class' => 'author'));?> :
					</b>
					<?php echo $comment['Comment']['text'] ?>
				</div>
				<div class="photodetail-comment-time time-ago">
					
					<span class="pull-right">
						<abbr class="time-ago" title="<?php echo $comment['Comment']['created_time'] ?>"><?php echo $comment['Comment']['created_time'] ?></abbr>
					</span>
				</div>
			</div>
		<?php endforeach ?>
	</div>
	<div class="photodetail-post-comment">
	
		<?php echo $this->Html->link(
			$this->Html->image(AuthComponent::user('User.profile_picture'), array('width' => '60', 'height' => '60')),
			array('controller' => 'u', 'action' => AuthComponent::user('User.username')),
			array('escape' => false, 'class' => 'pull-left')
	 	)?>
		<textarea class="post-comment" placeholder="Write a comment..."></textarea>
	</div>
</div>
<script type="text/template" id="comment-template">
	<% var root = '<?php echo $this->webroot ?>'; %>
	<div class="photodetail-comment-container">
		<div class="photodetail-avatar">
		 	<a href="<%= root + 'u/' + username %>">
			 	<img src="<%= root + 'img/' + profile_picture %>" width="40" height="40" alt="<%= username %>" />
			</a>
		</div>
			<div class="photodetail-caption-inner">
			<b>
				<a href="<%= root + 'u/' + username %>" class="author"><%= username %></a> :
			</b>
			<%= text %>
		</div>
		<div class="photodetail-comment-time time-ago">
			<span class="pull-right">
				<abbr class="time-ago" title="<%= created_time %>"><%= created_time %></abbr>
			</span>
		</div>
	</div>
</script>

<?php echo $this->Html->script(array('jquery.jscrollpane.min', 'jquery.mousewheel', 'underscore.min', 'jquery.timeago', 'jquery.textreplace'), array('inline' => false)) ?>
<?php echo $this->Html->scriptStart(array('inline' => false)) ?>
//<script>
var root = '<?php echo $this->webroot ?>';
var username = '<?php echo AuthComponent::user('User.username') ?>';
var photoId = '<?php echo $data['Photo']['id'] ?>';
var profile_picture = '<?php echo AuthComponent::user('User.profile_picture') ?>';
 $(document).ready(function(){	
	$('.photodetail-list-like, .photodetail-list-comment').jScrollPane();
	
	$('.more-opt').toggle(
		function(){
			$('.photodetail-group').fadeOut(0, function(){
				$('.photodetail-photo-inner.option').fadeIn(200);
				
			});	
		},
		function (){
			$('.photodetail-photo-inner.option').fadeOut(0, function(){
				$('.photodetail-group').fadeIn(200);
			});
			
			
		}
	);
	
	//like photo process
	$('.photodetail-like-btn').click(function(){
		var likeCount =  parseInt($('.photodetail-like-count').html());
		
		if ($(this).hasClass('active')){
			url =  root + 'ajax/callApi/unlikePhoto';
			$('.photodetail-like-count').html(likeCount - 1);
			$('.' + username + '-liked').remove();
		}
		else{
			url = root + 'ajax/callApi/likePhoto';
			$('.photodetail-like-count').html(likeCount + 1);
			$('.liked-user').append('<a class="' + username + '-liked" href="' + root + '/u/' + username + '">' + username + '</a>');
			
		}
		parent.$('.loading').show();
		$(this).toggleClass('active');
		$.ajax({
			url : url,
			type : 'POST',
			data : {'id' : photoId},
			complete : function(response){
				var result = $.parseJSON(response.responseText);
				parent.$('.loading').hide();
				if (!result.meta.success){
					
				}
			}
		});		
	});
	//share photo
	$('.share-submit').live('click', function(){
		var caption = $('.feedback-text').html();
		var photoId = '<?php echo $data['Photo']['id'] ?>';
		var photoUrl = '<?php echo h($data['Photo']['standard_resolution'])  ?>';
		var listSns = {
			'facebook' : false,
			'twitter' : false,
			'tumblr' : false,
			'flickr' : false
		};
		var name = '';
		
		$('.set-sns-btn').each(function(){
			if ($(this).hasClass('active')){
				name = $(this).attr('data-name');
				listSns[name] = true;
			}
				
		});
		$(this).hide();
		parent.$('.loading').show();
		$.ajax({
			url : root + 'social/postPhoto',
			type : 'POST',
			data : {'photoId' : photoId, 'photoUrl' : photoUrl, 'caption' : caption, 'facebook' : listSns.facebook, 'twitter' : listSns.twitter, 'tumblr' : listSns.tumblr, 'flickr' : listSns.flickr},
			complete : function (response){
				var result = $.parseJSON(response.responseText);
				
				$('.share-submit').show();
				if (result.upload_error.length > 0)
					alert('Failed upload to ' +  result.upload_error.join(', '))
				else {
					alert('uploaded');
				}	
			}
		});	
	});
	
	$('.set-sns-btn').click(function(){
		if ($(this).hasClass('on'))
			$(this).toggleClass('active');
		else {
			var socialName = $(this).attr('data-name');
			window.open(root +  'social/auth/' + socialName, '', 'width=980, height=600, directories=0, titlebar=0, toolbar=0, location=0, status=0, menubar=0, resizeable=no');
		}
	});
	
	//post comment
	$('.post-comment').keypress(function(e){
		if (e.keyCode == 13){
			e.preventDefault();
			var text = $(this).val();
			$(this).val('');
			
			parent.$('.loading').show();

			var template = _.template(
		     	$( "#comment-template" ).html()
		    );
		    var date=new Date();
		 	var time=date.toUTCString();
		 	
			var markup = template({text : text, created_time : time, username : username, profile_picture : profile_picture});
//			$('.photodetail-list-comment').append(markup);
			var pane = $('.photodetail-list-comment');
			pane.jScrollPane();
			var api = pane.data('jsp');
			api.getContentPane().append(markup);
			api.reinitialise();
			callback();
			//post comment
			$.ajax({
				url : root + 'ajax/callApi/postComment',
				type : 'POST',
				data : {'photo_id' : photoId, 'text' : text},
				complete : function (response){
					var result = $.parseJSON(response.responseText);
					parent.$('.loading').hide();
				}
			});
			
			var numberOfComments = parseInt($('.photodetail-view-all span').attr('data-count')) + 1;
			$('.photodetail-view-all span').attr('data-count', numberOfComments).html(numberOfComments);
		}
	});
	
	//load all comment
	$('.photodetail-view-all a').click(function(){
		$(this).remove();
		updateComment();

	});
	
	setInterval(function(){
		$('abbr.time-ago').timeago();
	}, 10000);
	
	callback();
});

function updateComment(){
	callback();
	parent.$('.loading').show();
	$.ajax({
		url : root + 'ajax/callApi/getCommentOfPhoto',
		type : 'POST',
		data : {'id' : photoId},
		complete : function (response){
			var result = $.parseJSON(response.responseText);
			parent.$('.loading').hide();
			for (var i = 0; i < result.data.length - 5; i++){
				var template = _.template(
			     	$( "#comment-template" ).html()
			    );
				var markup = template({text : result.data[i].Comment.text,
					created_time : result.data[i].Comment.created_time,
					username : result.data[i].User.username,
					profile_picture : result.data[i].User.profile_picture});
	//			$('.photodetail-list-comment').append(markup);
				var pane = $('.photodetail-list-comment');
				pane.jScrollPane();
				var api = pane.data('jsp');
				api.getContentPane().prepend(markup);
				api.reinitialise();
			}
		}
	});
}

function callback(){
	$('abbr.time-ago').timeago();
	$('.detail-caption, .photodetail-caption-inner').textreplace({
		root : root
	});
}

<?php echo $this->Html->scriptEnd() ?>