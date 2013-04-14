<?php if(!isset($keyword)):?>

<?php else: ?>
	<div class="search-result">
	</div>
	<script type="text/template" id="user-result">
		<% var root = '<?php echo $this->webroot ?>'; %>
		<div class="user-result">
			<a href="<%= root + 'u/' + user.username %>">
				<div class="margin10 result-avatar">
					<img src="<%= root + 'img/' + user.profile_picture %>" alt="<%= user.username %>" />
				</div>
				<div class="result-name">
					<span class="ellipsis">
						<h5><%= user.username %></h5>
					</span>
					<span class="ellipsis">
						<h6><%= user.first_name + user.last_name %></h6>
					</span>
				</div>
			</a>
		</div>
	</script>
	<script type="text/template" id="tag-result">
		<% var root = '<?php echo $this->webroot ?>'; %>
		<div class="tag-result user-result">
			<a href="<%= root + 'photo/channel/' + photo.tag.replace('#', '') %>">
				<div class="margin10 pull-left"  >
					<% $.each(photo.Photo, function(key, value){%>
						<img class="low pull-left" width="48" height="48" alt="" src="<%= root + 'img/' + value.Photo.thumbnail %>"/>								
					<% }); %>
		
				</div>
				
				<div class="tag-name">
					<h4><%= photo.tag %></h4>
				</div>
				<div class="tag-user-counter ellipsis">
					<h2><%= photo.photo_count %></h2>
					<span style="color: #FFF;">photos</span>
				</div>
				<div class="tag-photo-counter ellipsis">
					<h2><%= photo.user_count %></h2>
					<span style="color: #FFF;">users</span>
				</div>
			</a>
		</div>
	</script>
	<?php echo $this->Html->script(array('jquery.masonry.min', 'jquery.imagesloaded', 'autobrowse', 'underscore.min'), array('inline' => false)) ?>
	<?php echo $this->Html->scriptStart(array('inline' => false)) ?>
	//<script>
		var root = '<?php echo $this->webroot ?>';
		var loadingLock = true;
		var page = 0;
				
		$(document).ready(function(){
			$('.search-result').masonry({});
			loadResult();
			$('.loading').show();
			$(window).scroll(function(){     
				if(($(window).scrollTop() + $(window).height() > ($(document).height() - 400)) && loadingLock)
				{
					$('.loading').show();
					loadingLock = false;
					loadResult();
				}
			});
		});
		
		//load result from ajax request
		function loadResult(){
			$('.loading').show();
			$.ajax({
				url : root + 'ajax/callApi/search',
				type : 'POST',
				data : {'keyword' : '<?php echo h($keyword) ?>', page : page},
				complete : function (response){
					var result = $.parseJSON(response.responseText);
					$('.loading').hide();
					loadingLock = true;
					page = result.meta.next_page;
					if (!page){
						loadingLock = false;
					}
					
					for (var i = 0; i < result.data.Photo.length; i++){

						var template = _.template(
					     	$( "#tag-result" ).html()
					    );
						var markup = template({photo : result.data.Photo[i]});
						$('.search-result').append(markup);
						
		
					}
					
					for (var i = 0; i < result.data.User.length; i++){
						var userTemplate = _.template(
					     	$( "#user-result" ).html()
					    );
						var listMarkup = userTemplate({user : result.data.User[i].User});
						$('.search-result').append(listMarkup);								
					}
					callback();					
				}
			});		
		}
		function callback(){
			setTimeout(function(){
				$('.search-result').masonry();
				$('.search-result').masonry('reload');	
			}, 200);
		}
	<?php echo $this->Html->scriptEnd() ?>
<?php endif; ?>