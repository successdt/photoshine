
<div class="span12 upload-wrapper">
	<div class="upload-input span12" style="margin: 0 auto; display: inline-block;">
			
			<button class="btn btn-success pull-left margin5 choose-btn">
				<i class="icon-camera icon-white"></i>
				Choose photo
			</button>
			<span class="input-xxlarge uneditable-input pull-left margin5 file-src" ></span>
			<form method="POST" enctype="multipart/form-data" action="<?php echo $this->Html->url(array('controller' => 'Upload', 'action' => 'upload')) ?>">
				<input type="file" name="file" id="file" class="file-browser" style="display: none;" />
				<button type="submit" class="upload-next btn btn-warning pull-left margin5" title="submit">Next</button>		
			</form>
	</div>
	<div style="width: 100%;">
		<div style="width: 264px; margin: 50px auto;" class="alert alert-success">
			<p>Your photo must be at least 600x600 pixels.</p>
			<p>Allowed file types for upload are: jpg and png</p>
		</div>
		
	</div>
</div>
<?php echo $this->Html->scriptStart(array('inline' =>false)) ?>
//<script>
$(document).ready(function(){
	 var height = $('.upload-wrapper').outerHeight();
	 
	 //resize slidebox
	 parent.$('#slidebox, #slidebox iframe').css('height', height + 'px');
	 
	$('.choose-btn').click(function(){		
		$('.file-browser').trigger('click');
		
	});
	$('.file-browser').change(function(){
		$('.file-src').html($(this).val());
	});
	$('.upload-next').click(function(){
		parent.$('.loading').show();
	});
	
});
<?php echo $this->Html->scriptEnd() ?>