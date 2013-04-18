<?php
$facebook = array(
	'class' => '',
	'token' => ''
);
$twitter = array(
	'class' => '',
	'token' => '',
	'secret' => ''
);
if (isset($token['facebook_token']) && $token['facebook_token']){
	$facebook['class'] = 'on';
	$facebook['token'] = $token['facebook_token'];
}
if (isset($token['twitter_token']) && $token['twitter_token']){
	$twitter['class'] = 'on';
	$twitter['token'] = $token['twitter_token'];
	$twitter['secret'] = $token['twitter_secret'];
}
?>
<div style="width: 100%; height: auto">
	<div class="edit-profile-wrapper">
		<?php echo $this->element('Layouts/sidebar') ?>
		<div class="edit-profile">
			<div class="edit-profile-header btn-success">Find Friends</div>
			<div class="edit-profile-body">
				<hr />
				<div class="row-fluid">
					<div class="span4">
						<a href="javascript:void(0)">
							<div class="facebook find-fb-friend pull-right set-sns-btn <?php echo $facebook['class'] ?>" data-name="facebook"></div>
						</a>
					</div>
					<div class="span4">
		                  <input type="text" class="find-friend-input" autocomplete="off" placeholder="Search for users..."/>
		                  <button class="btn find-friend-submit"><i class="icon-search icon-black"></i></button>
					</div>
					<div class="span4">
						<a href="javascript:void(0)">
							<div class="twitter find-tw-friend pull-left set-sns-btn <?php echo $twitter['class'] ?>" data-name="twitter"></div>
						</a>
					</div>
				</div>
				<hr />
				<div class="find-friend-wrapper row-fluid">
					<?php
						$snsImage = array('suggest_type_facebook.png', 'suggest_type_twitter.png', '')
					?>
				</div>
			</div>
			<div class="edit-profile-footer btn-success"></div>
		</div>

	</div>
</div>

<script type="text/template" id="friend-template">
	<% var root = '<?php echo $this->webroot ?>'; %>
	<div class="friend-result <%= snsName %>-result">
		<div class="pull-left image80">
			<a href="<%= root + 'u/' + user.username %>">
				<img src="<%= root + 'img/' + user.profile_picture %>" class="image80"/>
			</a>
			<div class="sns-overlay">
				<img src="<%= root %>img/photoshine/suggest_type_<%= snsName %>.png"/>
			</div>
		</div>
		
		<div class="ellipsis friend-result-name">
			<div class="btn-success find-result-follow-btn follow-btn <%= user.following ? 'active' : 'follow' %> u<%= user.id %>" data-user-id="<%= user.id %>">
				<%= user.following ? 'Unfollow' : 'Follow' %>
			</div>
			<a href="<%= root + 'u/' + user.username %>">
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
var facebookToken = '<?php echo $facebook['token'] ?>';
var twitterToken = '<?php echo $twitter['token'] ?>';
var twitterSecret = '<?php echo $twitter['secret'] ?>';
var listFacebook =  null;
var listTwitter = null;

$(document).ready(function(){
	$('.set-sns-btn').click(function(){
		if ($(this).hasClass('on')){
			$(this).toggleClass('active');
			var snsName = $(this).attr('data-name');
			if ($(this).hasClass('active')){
				
				addFriend(snsName);				
			}
			else {
				$('.' + snsName + '-result').remove();
			}

		}
			
		else {
			var socialName = $(this).attr('data-name');
			window.open(root +  'social/auth/' + socialName, '', 'width=980, height=600, directories=0, titlebar=0, toolbar=0, location=0, status=0, menubar=0, resizeable=no');
		}
	});
	
	$('.find-friend-input').keyup(function(){
		var match = '';
		var keyword = $(this).val();
		var regex = new RegExp(keyword);
		
		
		$('.friend-result').hide();
		$('.friend-result').each(function(){
			var username = $(this).find('.username').html();
			var fullname = $(this).find('.fullname').html();
			
			match1 = username.search(regex);
			match2 = fullname.search(regex);
			if ((match1 > -1) || (match2 > -1)){
				$(this).show();
			}
		});
		
	});


});

	function addFriend(snsName){
		var ids = '';
		var idArray = [];
		
		$('.loading').show();
		if (snsName == 'facebook'){
			var url = 'https://graph.facebook.com/me/friends?access_token=' + facebookToken;
			while (url){
				$.ajax({
					url : url,
					async : false,
					complete : function(response){
						var result = $.parseJSON(response.responseText);
						
						for (var i = 0; i < result.data.length; i++){
							idArray.push(result.data[i].id);
						}
						if (typeof result.paging.next != 'undefined'){
							url = result.paging.next;
						}
						else {
							url = '';
						}
					}	
				});
							
			}
			getListFriends(idArray, snsName);
		}
		else {
			var url = 'https://api.twitter.com/1/friends/ids.json?cursor=-1&callback=?&id=<?php echo $token['twitter_id'] ?>';
			$.ajaxSetup( { "async": false } );
		    $.getJSON(url, function(data){
		    	getListFriends(data.ids, snsName);
		    });
		    
		}
		

	}
	
	function getListFriends(idArray, snsName){
		ids = idArray.join(',');
		$('.loading').hide();
		$.ajax({
			url : root + 'ajax/callApi/findFriendFromOtherServices',
			type : 'POST',
			data : {'ids' : ids, 'type' : snsName},
			complete : function(response){
				var result = $.parseJSON(response.responseText);
				var template = _.template(
			     	$( "#friend-template" ).html()
			    );
			    for (var i = 0; i < result.data.length; i++){
					var markup = template({user : result.data[i].User, snsName : snsName});
					$('.find-friend-wrapper').append(markup);			    	
			    }
				
			}
		})		
	}
<?php echo $this->Html->scriptEnd() ?>
<?php echo $this->element('follow'); ?>