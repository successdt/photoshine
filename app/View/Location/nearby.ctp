
<?php if (isset($latitude) && isset($longitude)): ?>
	<?php if (isset($locations) && $locations):?>
		<div id="location-canvas">
			
		</div>
		<div class="nearby-wrapper">
			<?php foreach ($locations as $location): ?>
			
				<div class="location-block">
					<a href="<?php echo $this->Html->url(array('controller' => 'Ui', 'action' => 'location')) ?>">
						<div class="location-block-img">
							<?php
							if (key_exists($location['id'], $locationInfo)){
								echo $this->Html->image($locationInfo[$location['id']]['thumbnail']);							
							}
							else {
								echo $this->Html->image('photoshine/noimage.jpg');
							}
							?>
						</div>
						<div class="location-block-info">
							<div class="nearby-location-name ellipsis">
								<?php 
								if (isset($location['name'])){
									echo $location['name'];
								}
							 	?>
							</div>
							<div class="nearby-location-desc">
								<?php
								$address = array();
								if (isset($location['location']['city'])){
									$address[0] = $location['location']['city'];
								}
								if (isset($location['location']['country'])){
									$address[1] = $location['location']['country'];
								}
								if (implode(', ', $address)){
									echo implode(', ', $address);
								}
								else {
									echo '-------------------';
								}
							 	?>
							</div>
							<div class="nearby-location-counter">
								<?php
								if (key_exists($location['id'], $locationInfo)){
									echo $locationInfo[$location['id']]['photo_count'];
								}
								else {
									echo '0';
								}
								?>
								<i class="icon-picture icon-black"></i>
							</div>
						</div>
					</a>
			</div>
			
			<?php endforeach; ?>
		</div>
	<?php else: ?>
		<div class="nearby-wrapper">
			<h1>No result</h1>
		</div>
	<?php endif ?>

	<?php echo $this->Html->script(array('https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false'), array('inline'=>false)) ?>
	<?php echo $this->Html->scriptStart(array('inline' =>false)) ?>
	//<script>
	var map;
	
	function showLocationMap(){
		var mapHeight = 200;
		var mapWidth = $('#location-canvas').innerWidth();
		var zoomLevel = 16;
		var centerLatLng = new google.maps.LatLng(<?php echo $latitude . ', ' . $longitude ?>);
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
		marker = new google.maps.Marker({
			position: centerLatLng,
			map: map,
			animation: google.maps.Animation.DROP,
		});
	}
	
	function reSize() {
		var cent=map.getCenter();
		document.getElementById("location-canvas").style.width="100%"
		google.maps.event.trigger(map,"resize");
		map.setCenter(cent);
	}
	
	$(document).ready(function(){
		
		showLocationMap();
		reSize();
	});
	<?php echo $this->Html->scriptEnd() ?>
<?php endif ?>