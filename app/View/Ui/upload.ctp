
<div class="span12 upload-wrapper">
	<div class="upload-input span12" style="margin: 0 auto; display: inline-block;">
			<input type="file" class="file-browser" style="display: none;" />
			<button class="btn btn-success pull-left margin5 choose-btn">
				<i class="icon-camera icon-white"></i>
				Choose photo
			</button>
			<span class="input-xxlarge uneditable-input pull-left margin5 file-src" >C:\Users\DuyThanh\Pictures\untitled.png</span>
			<button class="upload-next btn btn-warning pull-left margin5">Next</button>
	</div>
</div>
<?php echo $this->Html->scriptStart(array('inline' =>false)) ?>
//<script>
$(document).ready(function(){
	$('.choose-btn').click(function(){		
		$('.file-browser').trigger('click');
	});
	$('.file-browser').change(function(){
		$('.file-src').html($(this).val());
		console.log($(this));
	});
});
<?php echo $this->Html->scriptEnd() ?>