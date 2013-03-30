<?php
$facebook = array(
	'class' => '',
	'token' => ''
);
$twitter = array(
	'class' => '',
	'token' => '',
	'secret' => ''
);
$tumblr = array(
	'class' => '',
	'token' => '',
	'secret' => ''
);
$flickr = array(
	'class' => '',
	'token' => ''
);
if (isset($token['facebook_token']) && $token['facebook_token']){
	$facebook['class'] = 'active';
	$facebook['token'] = $token['facebook_token'];
}
if (isset($token['twitter_token']) && $token['twitter_token']){
	$twitter['class'] = 'active';
	$twitter['token'] = $token['twitter_token'];
	$twitter['secret'] = $token['twitter_secret'];
}
if (isset($token['tumblr_token']) && $token['tumblr_token']){
	$tumblr['class'] = 'active';
	$tumblr['token'] = $token['tumblr_token'];
	$tumblr['secret'] = $tumblr['tumblr_secret'];
}
if (isset($token['flickr_token']) && $token['flickr_token']){
	$flickr['class'] = 'active';
	$flickr['token'] = $token['flickr_token'];
}
?>

<div style="width: 100%; height: auto">
	<div class="edit-profile-wrapper">
	
		<?php echo $this->element('Layouts/sidebar') ?>
		<div class="edit-profile">
			<div class="edit-profile-header btn-success">Link To Other Services</div>
			<div class="edit-profile-body">
				<hr />
				<div class="row-fluid">
					<div class="span3"><div class="set-sns-btn fb facebook <?php echo $facebook['class'] ?>" data-name="facebook"></div></div>
					<div class="span3"><div class="set-sns-btn tw twitter <?php echo $twitter['class'] ?>" data-name="twitter"></div></div>
					<div class="span3"><div class="set-sns-btn tb tumblr <?php echo $tumblr['class'] ?>" data-name="tumblr"></div></div>
					<div class="span3"><div class="set-sns-btn fl flickr <?php echo $flickr['class'] ?>" data-name="flickr"></div></div>
				</div>
				<hr />
				<span style="font-size: 12px; font-style: italic;">Click to turn on or turn off the connection to other Socials</span>
				
			</div>
			<div class="edit-profile-footer btn-success"></div>
		</div>

	</div>
</div>
<?php echo $this->Html->scriptStart(array('inline' =>false)) ?>
//<script>
var root = '<?php echo $this->webroot ?>';
$(document).ready(function(){
	$('.set-sns-btn').click(function(){
		var snsName = $(this).attr('data-name');
		if ($(this).hasClass('active')){
			$(this).removeClass('active');
			$.ajax({
				url : root + 'ajax/callApi/removeServices',
				type : 'POST',
				data : {'type' : snsName},
				complete : function(response){
					
				}
			})
		}
		else {
			var socialName = $(this).attr('data-name');
			window.open(root +  'social/auth/' + socialName, '', 'width=980, height=600, directories=0, titlebar=0, toolbar=0, location=0, status=0, menubar=0, resizeable=no');
		}
	})
});
<?php echo $this->Html->scriptEnd() ?>