<div id="location-canvas">
	
</div>
<div class="location-info">
	<div class="location-info-inner">
		<div class="location-info-left">
			<div class="left-text">
				<span style="font-size: 50px;">60</span>
				<span>Photos</span>			
			</div>
		</div>
		<div class="location-info-center ellipsis">
			<span>
				<h2>Hoan Kiem Lake</h2>
				<h6>HANOI - VIETNAM</h6>
			</span>
			
			
		</div>
		<div class="location-info-right">
			<div class="right-text">
				<span style="font-size: 50px;">30</span>
				<span>Users</span>			
			</div>		
		</div>	
	</div>

</div>
<?php echo $this->element('photos_view'); ?>
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