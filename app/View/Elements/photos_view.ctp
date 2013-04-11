<div class="viewmode-btn">
	<div class="viewmode-group">
		<a href="javascript:void(0)" class="viewmode-grid" rel="tooltip" title="Grid view mode"></a>
		<a href="javascript:void(0)" class="viewmode-list active" rel="tooltip" title="List view mode"></a>
		<a href="javascript:void(0)" class="viewmode-map" rel="tooltip" title="Map view mode"></a>
	</div>
</div>
<div class="gridview-wrapper">

</div>

<div class="listview-wrapper">
</div>

<div class="mapview-wrapper">
	<div class="mapview-list-photo" style="height: auto; width: 100%; background-color: rgba(0, 0, 0, 0.8); float: left; display: none;">
		<div class="mapview-list-photo-container" style="float: left;"></div>
		<div class="control-outter" style="height: 20px; width: 100%; float: left;">
			<div style="width: 20px; margin: 0 auto;">
				<a href="#" onclick="hideMapList(); return false;">
					<i class="icon-eject icon-white"></i>
				</a>
			</div>
		</div>
	</div>
	<div id="location-canvas" style="height: 600px;"></div>
</div>


<script type="text/template" id="grid-template">
	<% var root = '<?php echo $this->webroot ?>'; %>
	<div class="gridview-block data-div photo_<%= photo.id %>" data-id="<%= photo.id %>">
		<div class="gridview-image">
		 	<a href="<%= root + 'photo/detail/' + photo.id %>">
			 	<img src="<%= root + 'img/' + photo.low_resolution_url %>" width="200" height="200" />
			 </a>
		</div>
		<div class="gridview-caption">
			<a href="<%= root + 'u/' + photo.User.name %>"><%= photo.User.username %></a> :
			<%= text2link(photo.caption, root) %>
		</div>
		<div class="gridview-static">
			<span class="pull-left time-ago">
				<i class="icon-time icon-black"></i><abbr class="time-ago" title="<%= photo.created_time %>"><%= photo.created_time %></abbr>
			</span>
			<span class="pull-right">
				<span class="gridview-like-btn <%= photo.user_had_liked ? 'active' : '' %> "></span>
				<span class="gridview-like-count"><%= photo.like_count %></span>
				<span class="gridview-comment-btn"></span>
				<span class="gridview-comment-count"><%= photo.comment_count %></span>
			</span>
		</div>
	</div>
</script>

<script type="text/template" id="list-template">
	<% var root = '<?php echo $this->webroot ?>'; %>
	<div class="listview-block data-div photo_<%= photo.id %>" data-id="<%= photo.id %>">
		<div class="listview-img">
		 	<a href="<%= root + 'photo/detail/' + photo.id %>">
			 	<img src="<%= root + 'img/' + photo.low_resolution_url %>" width="200" height="200" />
			 </a>
		</div>
		<div class="listview-sns">
			<a href="javascript:void(0)" class="pull-left  photodetail-like-btn btn btn-success <%= photo.user_had_liked ? 'active' : '' %>">
				<i class="icon-heart icon-white"></i>	
			</a>
			<a href="javascript:void(0)" class="pull-left sns-btn facebook"></a>
			<a href="javascript:void(0)" class="pull-left sns-btn twitter"></a>
			<a href="javascript:void(0)" class="pull-left sns-btn tumblr"></a>
			<a href="javascript:void(0)" class="pull-left sns-btn pinterest"></a>				
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
				<%= text2link(photo.caption, root) %>
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
			<a href="<%= root + 'photo/detail/' + photo.id %>">View all <span data-count="<%=photo.comment_count %>"><%=photo.comment_count %></span> comments</a>
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
<?php echo $this->Html->script(array('https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false'), array('inline'=>false)) ?>
<?php echo $this->Html->script(array('jquery.masonry.min', 'autobrowse', 'underscore.min', 'jquery.textreplace', 'jquery.timeago'), array('inline' => false)) ?>
<?php echo $this->Html->scriptStart(array('inline' => false)) ;?>
//<script>
	var root = '<?php echo $this->webroot ?>';
	var map;
	var shadowImageUrl = root + 'img/photoshine/map_shadow_medium.png';
	var id;
	var firstPhotos = [];
	var background = [];
	var photo = [];
	var marker = [];
	var photoIdArray = [];
	var photoUrlArray = [];
	var photoCount = 0;
	var loadingLock = true;
	var page = 0;

	
	$(document).ready(function(){
		
		
		$('.gridview-image a, .listview-img a, .view-all a').live('click', function(e){
			var url = $(this).attr('href') + '/popup';
			e.preventDefault();
			$().slidebox({
				iframe: true,
				height: 600,
				width: 958,
				href: url
			});
		});
		$('.viewmode-map').not('.active').click(function(){
			$('.viewmode-group').find('a').removeClass('active');
			$(this).addClass('active');
			$('.mapview-wrapper').show();
			$('.gridview-wrapper, .listview-wrapper').hide();
		});
		
		$('.viewmode-grid').not('.active').click(function(){
			$('.viewmode-group').find('a').removeClass('active');
			$(this).addClass('active');
			$('.gridview-wrapper').show();
			$('.mapview-wrapper, .listview-wrapper').hide();
		});
		
		$('.viewmode-list').click(function(){
			$('.viewmode-group').find('a').removeClass('active');
			$(this).addClass('active');
			$('.listview-wrapper').show().masonry();
			$('.mapview-wrapper, .gridview-wrapper').hide();
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
		$('.gridview-like-btn, .photodetail-like-btn').live('click', function(){
			var outter = $(this).closest('.data-div');
			var photoId = $(outter).data('id');
			var likeCount =  parseInt($(outter).find('.gridview-like-count').html());
			
			if ($(this).hasClass('active')){
				url =  root + 'ajax/callApi/unlikePhoto';
				$('.photo_' + photoId + ' .gridview-like-count').html(likeCount - 1);
				$('.photo_' + photoId).find('.gridview-like-btn').removeClass('active');
				$('.photo_' + photoId).find('.photodetail-like-btn').removeClass('active');
			}
			else{
				url = root + 'ajax/callApi/likePhoto';
				$('.photo_' + photoId + ' .gridview-like-count').html(likeCount + 1);
				$('.photo_' + photoId).find('.gridview-like-btn').addClass('active');
				$('.photo_' + photoId).find('.photodetail-like-btn').addClass('active');
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
		$('.viewmode-map').live('click', function(){
			showLocationMap();
			reSize();
			addMarkers();	
		});
		
		$(document).not('.mapview-list-photo').live('click', function(){
			$('.mapview-list-photo').hide();
		});
		
		setInterval(function(){
			$('abbr.time-ago').timeago();
		}, 10000);
		
		
	});
	
	//load photo from ajax request
	function loadPhotos(){
		$('.loading').show();
		$.ajax({
			url : '<?php echo $requestUrl ?>',
			type : 'POST',
			data : {<?php echo $requestParams ?>, page : page},
			complete : function (response){
				var result = $.parseJSON(response.responseText);
				$('.loading').hide();
				loadingLock = true;
				page = result.meta.next_page;
				if (!page){
					loadingLock = false;
				}
				
				for (var i = 0; i < result.data.length; i++){
					firstPhotos.push(result.data[i]);
					var template = _.template(
				     	$( "#grid-template" ).html()
				    );
					var markup = template({photo : result.data[i]});
					$('.gridview-wrapper').append(markup);
					
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
	
	
	function showLocationMap(){
		var mapHeight = $('.mapview-wrapper').innerHeight();
		var mapWidth = $('.mapview-wrapper').innerWidth();
		var zoomLevel = 12;
		var centerLatLng = new google.maps.LatLng(firstPhotos[0].Location.latitude, firstPhotos[0].Location.longitude);
		var mapOption = {
			center: centerLatLng,
			zoom: zoomLevel,
			mapTypeId: google.maps.MapTypeId.ROADMAP,
			disableDefaultUI: true,
		};
		var mapHolder = document.getElementById('location-canvas');
		mapHolder.style.height = mapHeight + 'px';
		mapHolder.style.width = mapWidth + 'px';
		map = new google.maps.Map(document.getElementById('location-canvas'), mapOption);
	}
	
	function reSize() {
		var cent=map.getCenter();
		document.getElementById("location-canvas").style.width="100%"
		google.maps.event.trigger(map,"resize");
		map.setCenter(cent);
	}
	
	function addMarkers(){
		for (var i = 0; i < firstPhotos.length; i++){
			addMarker(firstPhotos[i], i);
			photoIdArray[i] = parseInt(firstPhotos[i].id);
			photoUrlArray[i] = firstPhotos[i].low_resolution_url;
		}
		photoCount += firstPhotos.length;
	}
	function addMarker(photoObject, id){
    	latitudeLongitude = new google.maps.LatLng(photoObject.Location.latitude, photoObject.Location.longitude);
	    photo[id] = new google.maps.MarkerImage(
	        root + 'img/' + photoObject.low_resolution_url,
	        new google.maps.Size(80, 80),
	        new google.maps.Point(0, 0),
	        new google.maps.Point(40,98),
	        new google.maps.Size(80, 80)
	    );
		shadow = new google.maps.MarkerImage(
			shadowImageUrl,
			new google.maps.Size(101, 114),
			new google.maps.Point(0, 0),
			new google.maps.Point(47, 105),
			new google.maps.Size(100,114)
		);
		marker[id] = new google.maps.Marker({
	        position: latitudeLongitude,
	        map: map,
	        animation: google.maps.Animation.DROP,
	        icon: photo[id],
	        zIndex: id,
	    });  
		background[id] = new google.maps.Marker({
	        position: latitudeLongitude,
	        map: map,
	        animation: google.maps.Animation.DROP,
	        icon: shadow,
	        zIndex: id - 1,
	    });
		clickListener(id);	
	}
	
	function clickListener(id){		
		var overlapPhotoId = new Array();
		var overlay;
		var currentPoint;
		var overlapPoint;
		var overlapPhotoCount ;
					
		overlay = new google.maps.OverlayView();    
		overlay.draw = function(){};
		overlay.setMap(map);
		google.maps.event.addListener(marker[id], 'click', function() {
			overlapPhotoCount = 0;
			currentPoint = overlay.getProjection().fromLatLngToContainerPixel(marker[id].getPosition());;
			overlapPhotoId = [];<?php //empty this array ?>
			<?php //resize other markers to small size and find the overlap photos?>
			for (var i = 0; i < marker.length; i++){
				overlapPoint = overlay.getProjection().fromLatLngToContainerPixel(marker[i].getPosition());
				if ((Math.abs(currentPoint.x - overlapPoint.x) < 80) && (Math.abs(currentPoint.y - overlapPoint.y) < 80)){
					overlapPhotoId.push(i);
					overlapPhotoCount ++;
				}
			}					
			<?php //if current photo has overlap photo, show photo-slide?>
			if(overlapPhotoCount > 1){
				console.log(overlapPhotoId);
				showListOverlap(overlapPhotoId);
			}
			else {
				console.log(photoIdArray[id] );
				viewPhotoDetail(photoIdArray[id] );
			}		
		});
	}
	function viewPhotoDetail(id){
		var url = root + 'photo/detail/' + id + '/popup';
		$().slidebox({
			iframe: true,
			height: 600,
			width: 958,
			href: url
		});		
	}
	function showListOverlap(overlapPhotoId){
		var html = '';
		for (var i = 0; i < overlapPhotoId.length; i++){
			html += 
				'<div style="margin: 5px; float: left; height: 100px;">' +
					'<a href="' + root + "photo/detail/" + photoIdArray[overlapPhotoId[i]] + '" onclick="viewPhotoDetail(' + photoIdArray[overlapPhotoId[i]] + '); return false;">' +
						'<img src="' + root + 'img/' + photoUrlArray[overlapPhotoId[i]] + '" width="100" height="100">' +
					'</a>' +
				'</div>'
		}
		$('.mapview-list-photo-container').html(html);
		$('.mapview-list-photo').show();			
	}
	function hideMapList(){
		$('.mapview-list-photo').hide();
	}
<?php echo $this->Html->scriptEnd() ?>