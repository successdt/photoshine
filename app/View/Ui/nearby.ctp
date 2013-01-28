<div id="location-canvas">
	
</div>
<div class="nearby-wrapper">
	<?php for ($i = 0; $i < 32; $i++): ?>
	
		<div class="location-block">
			<a href="<?php echo $this->Html->url(array('controller' => 'Ui', 'action' => 'location')) ?>">
				<div class="location-block-img">
					<?php echo $this->Html->image('tmp/tmp' . rand(1, 10) . '.jpg'); ?>
				</div>
				<div class="location-block-info">
					<div class="nearby-location-name ellipsis">
						hanoi Helio Vietnam Speziality Coffee
					</div>
					<div class="nearby-location-desc">
						Hanoi, Vietnam
					</div>
					<div class="nearby-location-counter">
						30
						<i class="icon-picture icon-black"></i>
					</div>
				</div>
			</a>
	</div>
	
	<?php endfor; ?>
</div>
<?php echo $this->Html->script(array('https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false'), array('inline'=>false)) ?>
<?php echo $this->Html->scriptStart(array('inline' =>false)) ?>
//<script>
var map;

function showLocationMap(){
	var mapHeight = 200;
	var mapWidth = $('#location-canvas').innerWidth();
	var zoomLevel = 16;
	var centerLatLng = new google.maps.LatLng(21.028951, 105.852123);
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