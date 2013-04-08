<?php
/**
 * View list of photos on a map
 * @author thanhdd@lifetimetech.vn
 * 
 */  
?>
<div id="mini_map_canvas" style="width: 300px; height: 300px;">

</div>
<?php echo $this->Html->script(array('https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false'), array('inline'=>false)) ?>
<?php echo $this->Html->scriptStart(array('inline'=>false)) ?>
<?php
/**
 * init the mini map
 * @param PHP: latitude longitude ;
 * return HTML
 */ 
?>
//<script>
function initialize(){
	var root = '<?php echo $this->webroot ?>';
	var markerIconUrl = root+'img/meshtiles/map_marker.png';
	var centerLatitude = '<?php echo $latitude ?>';
	var centerLongitude = <?php echo $longitude ?>;
	
	if ((centerLatitude != 1000) && (centerLongitude != 1000)){
		var mapHeight = 300;
		var mapWidth = 300;
		var zoomLevel = 12;
		var centerLatLng = new google.maps.LatLng(centerLatitude, centerLongitude);

		var mapOption = {
			center: centerLatLng,
			zoom: zoomLevel,
			mapTypeId: google.maps.MapTypeId.ROADMAP,
			disableDefaultUI: true,
		};
		var mapHolder = document.getElementById('mini_map_canvas');
		mapHolder.style.height = mapHeight + 'px';
		mapHolder.style.width = mapWidth + 'px';
		map = new google.maps.Map(document.getElementById('mini_map_canvas'), mapOption);
		marker = new google.maps.Marker({
			position: centerLatLng,
			map: map,
			animation: google.maps.Animation.DROP,
		});
	}

}
$('.more-opt').one('click', function(){
	setTimeout(function(){
		initialize();
	}, 500);
	
});
<?php echo $this->Html->scriptEnd() ?>


