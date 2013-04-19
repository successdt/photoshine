<?php if (!isset($type) || !isset($userId)){
	die;
}
?>
<div style="width: 958px; height: 400px;" class="follower-wrapper">
	<div class="find-friend-wrapper" style="width: 958px; height: auto"></div>
</div>

<script type="text/template" id="friend-template">
	<% var root = '<?php echo $this->webroot ?>'; %>
	<div class="friend-result result">
		<div class="pull-left image80">
			<a href="<%= root + 'u/' + user.username %>" target="_blank">
				<img src="<%= root + 'img/' + user.profile_picture %>" class="image80"/>
			</a>
		</div>
		
		<div class="ellipsis friend-result-name">
			<div class="btn-success find-result-follow-btn follow-btn <%= user.following ? 'active' : 'follow' %> u<%= user.id %>" data-user-id="<%= user.id %>">
				<%= user.following ? 'Unfollow' : 'Follow' %>
			</div>
			<a href="<%= root + 'u/' + user.username %>" target="_blank">
				<span class="username">
					<%= user.username %>
				</span>
				<br />
				<span class="ellipsis fullname" style="color: #666;">
					<%= user.first_name + ' ' + user.last_name %>
				</span>
			</a>
		</div>
	</div>
</script>
<?php echo $this->Html->script(array('underscore.min'),  array('inline' => false)); ?>
<?php echo $this->Html->scriptStart(array('inline' =>false)) ?>
//<script>
var root = '<?php echo $this->webroot ?>';
var type = '<?php echo $type ?>';
var userId = '<?php echo $userId ?>';
var page = 0;
var loadingLock = true;
$(document).ready(function(){
	parent.$('.loading').hide();
	getListFriends();
	$(window).scroll(function(){     
		if(($('.follower-wrapper').scrollTop() + $('.follower-wrapper').height() > ($('.find-friend-wrapper').height() - 200)) && loadingLock)
		{
			$('.loading').show();
			loadingLock = false;
			getListFriends();
		}
	});
	var height = $('.follower-wrapper').outerHeight(true) + 5;
	//resize slidebox
	parent.$('#slidebox, #slidebox iframe').css('height', height + 'px');
});

function getListFriends(){

	parent.$('.loading').show();
	$.ajax({
		url : root + 'ajax/callApi/getListFollowerAndFollowing',
		type : 'POST',
		data : {'type' : type, 'user_id' : userId, 'page' : page},
		complete : function(response){
			parent.$('.loading').hide();
			var result = $.parseJSON(response.responseText);
			var template = _.template(
		     	$( "#friend-template" ).html()
		    );
		    for (var i = 0; i < result.data.length; i++){
				var markup = template({user : result.data[i].User});
				$('.find-friend-wrapper').append(markup);			    	
		    }
		    page = result.meta.next_page;
			loadingLock = true;
		}
	})		
	}
<?php echo $this->Html->scriptEnd() ?>
<?php echo $this->element('follow'); ?>