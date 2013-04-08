<div class="btn-success skew-label">Popular</div>
<div style="width: 100%; height: 50px;"></div>
<?php 
 echo $this->element('photos_view', array(
		'requestUrl' => $this->Html->url(array('controller' => 'ajax', 'action' => 'callApi', 'getPopularPhotos')),
		'requestParams' => "tag: ''"
	));
?>