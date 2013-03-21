<?php echo $this->Html->css(array('jquery.jscrollpane')) ?>
<div id="process-box" class="post-photo-popup" style="width: 770px; margin: 0 auto;">
	<div id="process-container-box" class="row-fluid">
		<div class="process-left-box">	
			<div style="margin: 5px 0px">
				<button class="btn-danger btn-large" id="back-button" style="width: 120px;">Back</button>
				<button onclick="rotate()" class="btn btn-primary btn-large" style="width: 154px">
					<i class="icon-repeat icon-white"></i>
					Rotate
				</button>
				<button class="btn-success btn-large" id="next-button" style="width: 120px;">Next</button>		
			</div>
			<div class="soure-image-container">
				<?php echo $this->Html->image('upload/filters/' . session_id() . '/filter/input.jpg?noCache=' . time(), array('class' => 'source-img', 'width' => '400px')) ?>
			</div>
			<div class="location-layer">
				<div>
					<?php echo $this->Html->image('frames/place.png') ?>
				</div>
				<div class="location-text-title ellipsis"></div>
				<div class="location-text-desc ellipsis"></div>				
			</div>
			<div class="frame-container"></div>
			
		</div>
	
		<div class="process-right-box">
			
			<ul class="nav nav-tabs" style="width: 340px; margin-top: 10px;">
			  <li class="active"><a href="#filter" data-toggle="tab">Filters</a></li>
			  <li><a href="#frame" data-toggle="tab">Frame</a></li>
			  <li><a href="#location" data-toggle="tab" class="place">Location</a></li>
			</ul>
			
			<div class="tab-content process-tab">
				<div class="tab-pane active" id="filter" style="width: 345px; margin-top: 5px;">
						<?php 
							$filterList = array(
								'reset', 'beauty', 'bright', 'brownish', 'chrome', 'griseous',
								'happytear', 'inkwash', 'instant', 'lomo', 'nostalgia',
								'retro', 'richtone', 'sunrise', 'vibrant', 'xpro'
							);
						?>
						<?php foreach ($filterList as $filter) : ?>
							<div class="func-preview" style="width: 76px; float: left; margin: 2px 5px;">
								<?php 
									echo $this->Html->image(
										'upload/filters/' . session_id() . "/thumb/{$filter}.jpg?noCache=" . time(), 
										array('alt' => "{$filter}", 'class' => "filter-func func-{$filter}")
									) 
								?>
								<div style="font-size: 14px; text-align: center;">
									<?php echo ucwords($filter) ?>
								</div>
							</div>
						<?php endforeach; ?>		  
				</div>
				<div class="tab-pane" id="frame" style="width: 345px; margin-top: 5px;">
						<?php 
							$frammeList = array(
								'none', 'edge', 'kelvin', 'nashville', 'pastel', 'pink', 'psychedelic', 'punched',
								'rainbow', 'retro', 'satin', 'splash', 'wave', 'green', 'heart', 'antique'
							);
						?>
						<?php foreach ($frammeList as $frame) : ?>
							<div class="frame-preview" style="width: 76px; float: left; margin: 2px 5px;">
								<div style="background-image: url('<?php echo $this->webroot . 'img/upload/filters/' . session_id() . '/thumb/reset.jpg?noCache=' . time() ?>');">
								<?php 
									echo $this->Html->image(
										"frames/{$frame}_thumb.png", 
										array('alt' => "{$frame}", 'class' => "frame-func func-{$frame}")
									) 
								?>
								</div>
								<div style="font-size: 14px; text-align: center;">
									<?php echo ucwords($frame) ?>
								</div>
							</div>
						<?php endforeach; ?>				
				</div>
				
				<div class="tab-pane" id="location" style="width: 345px; margin-top: 5px;">
					<div style="margin: 5px 5px;">
						<div class="input-append">
							<input style="width: 278px;" id="place-search" type="text" placeholder="Search for location">
							<button class="btn" type="button" id="place-submit"><i class="icon-search"></i></button>
						</div>
						<div class="location-result">

						</div>
						<p class="location-select ellipsis">
							<a class="remove-place" href="javascript:void(0)"><i class="icon-remove"></i></a>
							<span data-id="0">							
							</span>
						</p>
						<div style=" width: 325px; margin: 5px auto; text-align: center;">
							<button class="btn btn-success" id="add-text">
								<i class="icon-plus icon-white"></i>
								Address on photo
							</button>
							<button class="btn btn-success" id="remove-text" style="display: none;">
								<i class="icon-minus icon-white"></i>
								Remove text
							</button>							
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php echo $this->Html->script(array('jquery.jscrollpane.min', 'jquery.mousewheel'), array('inline' => false)) ?>
<?php echo $this->Html->scriptStart(array('inline' => false)) ?>
//<script>
	var recentFilter = null;
	

	
	//hide loading
	parent.$('.loading').hide();
	
	function rotate() {
		parent.$('.loading').show();
	
		if (recentFilter) {
			recentFilter.abort();
		}
		
		recentFilter = $.ajax({
			url: '<?php echo $this->Html->url(array('controller' => 'upload', 'action' => 'rotate')) ?>' + '?nocache=' + (new Date().getTime()),
			async: true,
			success: function() {
				$('.source-img').attr('src', '<?php echo $this->webroot . 'img/upload/filters/' . session_id() . '/filter/' ?>' + 'output.jpg?nocache=' + (new Date().getTime())).load(function(){
					parent.$('.loading').hide();
				});
			}
		});
	}
	
	function reset() {
		parent.$('.loading').show();
	
		if (recentFilter) {
			recentFilter.abort();
		}
		
		recentFilter = $.ajax({
			url: '<?php echo $this->Html->url(array('controller' => 'upload', 'action' => 'reset')) ?>' + '?nocache=' + (new Date().getTime()),
			async: true,
			success: function() {
				$('.source-img').attr('src', '<?php echo $this->webroot . 'img/upload/filters/' . session_id() . '/filter/' ?>' + 'output.jpg?nocache=' + (new Date().getTime())).load(function(){
					parent.$('.loading').hide();
				});
			}
		});
	}

	$(document).ready(function(){
		var lat = 0;
		var lon = 0;
		var place = { id : {}};
		
		$('#add-text').click(function(){
			var id = $('.location-select span').attr('data-id');
			id = parseInt(id);
			
			if (id){

				$('.location-layer').addClass('active');
				$('.location-text-title').html(place[id].name);
				$('.location-text-desc').html(place[id].location.city + ' ' + place[id].location.country);
				$('#remove-text').show();
				$(this).hide();		
			}

			
		});
		 $('#remove-text').click(function(){
			$('.location-layer').removeClass('active');
			$(this).hide();
			$('#add-text').show();
		});
		
		//filter clicked
		$('.filter-func').click(function(){
			
			parent.$('.loading').show();
			$('.filter-func').removeClass('active');
			$(this).addClass('active');
			
			var filter = $(this).attr('alt');
			
			if (recentFilter) {
				recentFilter.abort();
			}
			
			
			recentFilter = $.ajax({
				url: '<?php echo $this->Html->url(array('controller' => 'upload', 'action' => 'magick')) ?>',
				type: 'POST',
				data: {'name': filter, 'noCache': new Date().getTime()},
				complete: function() {
					$('.source-img').attr('src', '<?php echo $this->webroot . 'img/upload/filters/' . session_id() . '/filter/' ?>' + 'output.jpg?nocache=' + (new Date().getTime())).load(function(){
						parent.$('.loading').hide();
					});
				}
			});
		});
		
		
		//frame click
		$('.frame-func').click(function(){
			var frame = $(this).attr('alt');
			
			$('.frame-func').removeClass('active');
			$(this).addClass('active');
			$('.frame-container').addClass('active');
			
			$('.frame-container').html('<img src="<?php echo $this->webroot ?>img/frames/' + frame + '.png"></img>')
		});

		//next click
		$('#next-button').click(function(){
			var frameName = $('.frame-func.active').attr('alt');
			var id = parseInt($('.location-select span').attr('data-id'));
			var locationId = 0;
			var latitude = 0;
			var longitude = 0;
			var placeName = '';
			var placeAdd = '';
			
			if(typeof frameName == 'undefined')
				frameName = 'none';
			if(id){
				locationId = place[id].id;
				latitude = place[id].location.latitude;
				longitude = place[id].location.longitude;
			}
			if ($('.location-layer').hasClass('active')){
				placeName = $('.location-text-title').html();
				placeAdd = $('.location-text-desc').html();
			}

			$('.loading').show();
			$.ajax({
				url: '<?php echo $this->Html->url(array('controller' => 'upload', 'action' => 'postPhoto')) ?>',
				type: 'POST',
				data: {'frame' : frameName, 'id' : id, 'latitude' : latitude, 'longitude' : longitude, 'placeName' : placeName, 'placeAdd' : placeAdd},
				complete: function(response) {
					parent.$('.loading').hide();
					
					var result =  $.parseJSON(response.responseText);
					$('.loading').hide();
					if (result.status == 'success' && result.id) {
						
					} else {
						alert('<?php echo __('Posting failed! Please try again.') ?>');
					}
				}
			});
		});
		
		$('#back-button').click(function(){
			window.location.href = '<?php echo $this->Html->url(array('controller' => 'upload', 'action' => 'crop')) ?>';
		});
		
		//show jpane
		$('#location').addClass('active');
		$('.location-result').jScrollPane();
		$('#location').removeClass('active');
		
		var height = $('#process-box').outerHeight() + 5;
		//resize slidebox
		parent.$('#slidebox, #slidebox iframe').css('height', height + 'px');
		
		<?php if (isset($latitude) && $latitude && isset($longitude) && $longitude): ?>
		lat = '<?php echo $latitude ?>';
		lon = '<?php echo $longitude ?>';
		$('.loading').show();
		$.ajax({
			url : 'https://graph.facebook.com/search?type=place&center=' + lat + ',' + lon + '&distance=1000&access_token=<?php echo FB_TOKEN ?>',
			complete : function(response){
				var result = $.parseJSON(response.responseText);
				showResult(result.data);
				$('.loading').hide();
			}	
		});
		<?php endif; ?>
		
		
		$('#place-submit').live('click', function(){
			var keyword = $('#place-search').val();
			
			$('.loading').show();
			$.ajax({
				url : 'https://graph.facebook.com/search?q=' +  keyword + '&type=place&access_token=<?php echo FB_TOKEN ?>',
				complete : function(response){
					var result = $.parseJSON(response.responseText);
					showResult(result.data);
					$('.loading').hide();
				}	
			});			
		});
		
		$('.location-row').live('click', function(){
			var id = $(this).attr('data-id');
			var text = $(this).html();

			$('.location-select span').html(text).attr('data-id', id);

		});
		
		$('.location-select i').live('click', function(){
			$('.location-select span').html('').attr('data-id', 0);
		});
		
		function showResult(data){
			$('.location-result').html('');
			
			for (var i = 1; i < data.length; i++){
				data[i].name = (typeof data[i].name === 'undefined') ? '' : data[i].name;
				data[i].location.street = (typeof data[i].location.street === 'undefined') ? '' : data[i].location.street;
				data[i].location.city = (typeof data[i].location.city === 'undefined') ? '' : data[i].location.city;
				data[i].location.country = (typeof data[i].location.country === 'undefined') ? '' : data[i].location.country;
				
				place[data[i].id] = {'location' : data[i].location, 'name' : data[i].name};
				$('.location-result').append('<div class="location-row" data-id="' + data[i].id + '">' + data[i].name +
					' ' + data[i].location.street + ' ' + data[i].location.city + '</div>');
			}
		}
	});
<?php echo $this->Html->scriptEnd() ?>