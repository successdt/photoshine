
<?php if(isset($token) && isset($photoId)): ?>
<div class="finish-wrapper" style="width: 920px; height: 245px; margin: 10px auto;">
	<div class="row-fluid">
		<div class="span8">
				<?php
					$sns = array('fb' => 'facebook','tw' => 'twitter','tb' => 'tumblr','fl' => 'flickr');
					foreach ($sns as $key => $value):
						if (isset($token[$value . '_token']) && $token[$value . '_token']):

	
 				?>
					<div class="span3"><div class="set-sns-btn on <?php echo $key . ' ' . $value ?> active" data-name="<?php echo $value ?>"></div></div>
				<?php else: ?>
					<div class="span3"><div class="set-sns-btn <?php echo $key . ' ' . $value ?>" data-name="<?php echo $value ?>"></div></div>
				<?php
						endif;
					endforeach
				?>
			<div class="span12">
				<textarea class="caption-text" style="width: 585px; height: 130px; margin-top: 30px;" placeholder="Photo caption..." maxlength="1000"></textarea>
			</div>	
		</div>
		<div class="span4">
			<div class="margin5" style="margin-top: 0px; height: 42px;">
				<button class="btn-success btn-large finish-btn" style="width: 204px;">Finish</button>
			</div>
			<div class="span4">
				<div class="input-prepend input-append" style="margin-top: 25px;">
				  <span class="add-on">
				  	<i class="icon-tag"></i>
				  </span>
				  <input class="span2 addtag1" id="appendedPrependedInput" placeholder="#tag" type="text" maxlength="16" style="width: 150px;">
				  <span class="add-on">
				  	<i class="icon-plus"></i>
				  </span>
				</div>
				<p class="tag1-text ellipsis" style="width: 202px; height: 30px; white-space: nowrap;"></p>
				<div class="input-prepend input-append">
				  <span class="add-on">
				  	<i class="icon-tag"></i>
				  </span>
				  <input class="span2 addtag2 " id="appendedPrependedInput" placeholder="#tag" type="text" maxlength="16" style="width: 150px;">
				  <span class="add-on" >
				  	<i class="icon-plus"></i>
				  </span>
				</div>				
				<p class="tag2-text ellipsis" style="width: 202px; height: 30px; white-space: nowrap;"></p>
			</div>
		</div>
	</div>
</div>

<?php endif; ?>

<?php echo $this->Html->scriptStart(array('inline' => false)) ?>
//<script>
var root = '<?php echo $this->webroot ?>';

$(document).ready(function(){
	//hide loading
	parent.$('.loading').hide();
	
	var height = $('.finish-wrapper').outerHeight(true) + 5;
	//resize slidebox
	parent.$('#slidebox, #slidebox iframe').css('height', height + 'px');
	
	$('.set-sns-btn').click(function(){
		if ($(this).hasClass('on'))
			$(this).toggleClass('active');
		else {
			var socialName = $(this).attr('data-name');
			window.open(root +  'social/auth/' + socialName, '', 'width=980, height=600, directories=0, titlebar=0, toolbar=0, location=0, status=0, menubar=0, resizeable=no');
		}
	});
	
	$('.finish-btn').click(function(){
		var caption = $('.caption-text').val();
		var arrTag = [$('.addtag1').val(), $('.addtag2').val()];
		var tags = arrTag.join(',');
		var photoId = '<?php echo $photoId ?>';
		parent.$('.loading').show();
		
		$(this).hide();
		$.ajax({
			url : root + 'ajax/callApi/updatePhoto',
			type : 'POST',
			data : {'caption' : caption, 'tags' : tags, 'photoId' : photoId},
			complete : function (response){
				var result = $.parseJSON(response.responseText);
				
				if (result.meta.success)
					sharePhoto();
				else
					alert(result.meta.error_message);	
			}
		});
	});
	parent.$('#slidebox').addClass('confirm');
	
	function sharePhoto(){
		var caption = $('.caption-text').val();
		var photoId = '<?php echo $photoId ?>';
		var photoUrl = '<?php echo h($photoUrl)  ?>';
		var listSns = {
			'facebook' : false,
			'twitter' : false,
			'tumblr' : false,
			'flickr' : false
		};
		var name = '';
		var enableSharing = false;
		
		$('.set-sns-btn').each(function(){
			if ($(this).hasClass('active')){
				name = $(this).attr('data-name');
				listSns[name] = true;
				enableSharing = true;
			}
		});
		
		if (enableSharing){
			$.ajax({
				url : root + 'social/postPhoto',
				type : 'POST',
				data : {'photoId' : photoId, 'photoUrl' : photoUrl, 'caption' : caption, 'facebook' : listSns.facebook, 'twitter' : listSns.twitter, 'tumblr' : listSns.tumblr, 'flickr' : listSns.flickr},
				complete : function (response){
					var result = $.parseJSON(response.responseText);
					parent.$('.loading').hide();
					$('.finish-btn').show();
					if (result.upload_error.length > 0)
						alert('Failed upload to ' +  result.upload_error.join(', '))
					else
						parent.$().slidebox.close();	
				}
			});				
		}
		else {
			parent.$('.loading').hide();
			parent.$().slidebox.close();
		}
		

	}
});

<?php echo $this->Html->scriptEnd() ?>