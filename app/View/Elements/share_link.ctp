<?php echo $this->Html->scriptStart(array('inline' =>false)) ?>
//<script>
function share(name, thumbnail, photoId, caption){
	<?php

	$serverName = $_SERVER['SERVER_NAME'];
	$shareUrl = 'http://' . $serverName . $this->Html->url(array('controller' => 'photo', 'action' => 'detail', 'photo_id'));
	$facebookConfig = Configure::read('Facebook.config');
	$callbackUrl = 'http://' . $_SERVER['SERVER_NAME'] . Router::url(array(
		'controller' => 'social',
		'action' => 'share'			
	));
	$fbParams = array(
		'app_id' => $facebookConfig['appId'],
		'link' => $shareUrl,
		'picture' => 'http://' . $serverName . $this->webroot . 'img/thumbnail',
		'caption' => 'photo_caption',
		'name' => 'Photoshine',
		'description' => 'Share your photos on Photoshine',
		'redirect_uri' => $callbackUrl . '/fb'	
	);
	$twParams = array(
		'text' => 'photo_caption',
		'url' => $shareUrl,
		'related' => ''
	);
	$tbParams = array(
		's' => '',
		't' => 'photo_caption',
		'u' => $shareUrl,
		'v' => '3'
	);
	$pinParams = array(
		'media' => 'http://' . $serverName . $this->webroot . 'img/thumbnail',
		'url' => $shareUrl,
		'description' => 'photo_caption',
		
		
	);
 	?>
 	var fbUrl = '<?php echo 'https://www.facebook.com/dialog/feed?' . http_build_query($fbParams) ?>';
 	var twUrl = '<?php echo 'https://twitter.com/intent/tweet?' . http_build_query($twParams) ?>';
 	var tbUrl = '<?php echo 'http://www.tumblr.com/share?' . http_build_query($tbParams) ?>';
 	var pinUrl = '<?php echo 'http://pinterest.com/pin/create/button/?' . http_build_query($pinParams) ?>';
 	fbUrl = fbUrl.replace(/&amp;/gi, '&').replace(/thumbnail/gi, thumbnail).replace(/photo_id/gi, photoId).replace(/photo_caption/gi, caption);
 	twUrl = twUrl.replace(/&amp;/gi, '&').replace(/thumbnail/gi, thumbnail).replace(/photo_id/gi, photoId).replace(/photo_caption/gi, caption);
 	tbUrl = tbUrl.replace(/&amp;/gi, '&').replace(/thumbnail/gi, thumbnail).replace(/photo_id/gi, photoId).replace(/photo_caption/gi, caption);
 	pinUrl = pinUrl.replace(/&amp;/gi, '&').replace(/thumbnail/gi, thumbnail).replace(/photo_id/gi, photoId).replace(/photo_caption/gi, caption);
 	switch(name) {
 		case 'facebook':
 			window.open(fbUrl, 'share to facebok', 'with=800, height=600');
		break;
 		case 'twitter':
 			window.open(twUrl, 'share to twitter', 'with=800, height=600');
		break;
		case 'tumblr':
			window.open(tbUrl, 'share to tumblr', 'with=800, height=600');
		break;
		case 'pinterest':
			window.open(pinUrl, 'pin it', 'with=800, height=600');
		break;
 	}
}

<?php echo $this->Html->scriptEnd() ?>