<div id="process-box" class="post-photo-popup" style="width: 770px; margin: 0 auto;">
	<div id="process-container-box" class="row-fluid">
		<div class="process-left-box">	
			<div style="margin: 5px 0px">
				<button class="btn-danger btn-large" id="back-button" style="width: 120px;">Back</button>
				<button onclick="rotate()" class="btn btn-primary btn-large" style="width: 154px">Rotate</button>
				<button class="btn-success btn-large" id="next-button" style="width: 120px;">Next</button>		
			</div>
			<div class="soure-image-container">
				<?php echo $this->Html->image('upload/filters/' . session_id() . '/filter/input.jpg?noCache=' . time(), array('class' => 'source-img', 'width' => '400px')) ?>
			</div>
			<div class="location-layer">
				<div>
					<?php echo $this->Html->image('frames/place.png') ?>
				</div>
				<div class="location-text-title ellipsis">
					VIETA BUILDING
				</div>
				<div class="location-text-desc ellipsis">
					DUY TAN, HANOI | VIETNAM
				</div>				
			</div>
			<div class="frame-container"></div>
			
		</div>
	
		<div class="process-right-box">
			
			<ul class="nav nav-tabs" style="width: 340px; margin-top: 10px;">
			  <li class="active"><a href="#filter" data-toggle="tab">Filters</a></li>
			  <li><a href="#frame" data-toggle="tab">Frame</a></li>
			  <li><a href="#location" data-toggle="tab">Location</a></li>
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
				<div class="tab-pane" id="frame">
						<?php 
							$frammeList = array(
								'kelvin', 'nashville', 'edge'
							);
						?>
						<?php foreach ($frammeList as $frame) : ?>
							<div class="frame-preview" style="width: 76px; float: left; margin: 2px 5px;">
								<div style="background-image: url('<?php echo $this->webroot . 'img/upload/filters/' . session_id() . '/thumb/reset.jpg?noCache=' . time() ?>');">
								<?php 
									echo $this->Html->image(
										"frames/{$frame}_thumb.png?noCache=" . time(), 
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
				<div class="tab-pane" id="location">...</div>
			</div>
			

			
			
			
		</div>
	</div>
</div>

<?php echo $this->Html->scriptStart(array('inline' => false)) ?>
//<script>
	var recentFilter = null;
	
	var height = $('#process-box').outerHeight();
	//resize slidebox
	parent.$('#slidebox, #slidebox iframe').css('height', height + 'px');
	
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

		
		$('#process-box .next-btn').click(function(){
			
			var params = new Object();
			params.filter_id = $('.filter-func').index($('.filter-func.active')) + 1;
			
			$.ajax({
				url: '<?php echo $this->Html->url(array('controller' => 'post', 'action' => 'postPhotoFirst')) ?>',
				complete: function(response) {
					parent.$('.loading').hide();
					
					var json =  $.parseJSON(response.responseText);
					
					if (response.status = '200' && response.statusText == 'OK' && json.photo_id) {
						params.photo_id = json.photo_id;
						params.photo_url = json.photo_url;
					
						parent.$.colorbox({href: '<?php echo $this->Html->url(array('controller' => 'post', 'action' => 'share')) ?>' + '?' + $.param(params), iframe:true, innerWidth: '619px', innerHeight: '921px', close: ''});
					} else {
						alert('<?php echo __('Posting failed! Please try again.') ?>');
					}
				}
			});
		});
		
		$('#back-button').click(function(){
			window.location.href = '<?php echo $this->Html->url(array('controller' => 'upload', 'action' => 'crop')) ?>';
		});
		
		$(function () {
			$('#myTab a:last').tab('show');
		})
	});
<?php echo $this->Html->scriptEnd() ?>