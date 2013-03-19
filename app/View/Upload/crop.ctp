<?php if (isset($data['source']) && $data['source']): ?>
<div class="crop-wrapper">
	<div class="crop-btn">
		<button class="btn-danger btn-large" id="back-button" style="width: 299px;">Back</button>
		<button class="btn-success btn-large" id="next-button" style="width: 299px;">Next</button>
	</div>
	<hr />
		<div style="text-align: center;">Click and drag mouse to select a crop area</div>
	<hr />
	<div class="crop-area">
		<?php 
			$imagePath = $this->Html->url('/img/upload/tmp/', true) . session_id() . '.jpg';
			$dimension = @getimagesize($imagePath);
		?>
		
		<?php if ($dimension) : ?>
			<?php if ($dimension[0] == $dimension[1]) : ?>
				<div class="row-fluid" style="width: 600px; height: 600px; margin-top: 5px;">
					<?php echo $this->Html->image($imagePath . '?noCache=' . time(), array('id' => 'source-img')) ?>
				</div>
			<?php else : ?>
				<div class="row-fluid" id="crop-photo-container">
					<?php 
						$limitDim = 'width';
						if ($dimension[1] > $dimension[0]) {
							$limitDim = 'height';
						}
						
						echo $this->Html->image($imagePath . '?noCache=' . time(), array('id' => 'source-img', 'style' => "{$limitDim}: 600px"));
					?>
				</div>
			<?php endif; ?>
		<?php endif; ?>
	</div>
	
	<?php
		echo $this->Form->create('crop', array('id' => 'crop-photo-form', 'style' => 'display: none;'));
		echo $this->Form->input('x1', array('type' => 'hidden', 'id' => 'param-x1'));
		echo $this->Form->input('y1', array('type' => 'hidden', 'id' => 'param-y1'));
		echo $this->Form->input('size', array('type' => 'hidden', 'id' => 'param-size'));
		echo $this->Form->end();
	?>
</div>
<?php endif ?>
<?php echo $this->Html->css(array('imgareaselect/imgareaselect-default'), null, array('inline' => false)) ?>
<?php echo $this->Html->script(array('jquery.imgareaselect.min'), array('inline' => false))?>
<?php echo $this->Html->scriptStart(array('inline' =>false)) ?>
//<script>
$(document).ready(function(){
	
	 var height = $('.crop-wrapper').outerHeight();
	 
	 //resize slidebox
	 parent.$('#slidebox, #slidebox iframe').css('height', height + 'px');
	 
	 //hide loading
	 parent.$('.loading').hide();
	 
	$('#source-img').imgAreaSelect({
		handles: true,
		aspectRatio: '1:1',
		onSelectEnd: function (img, selection) {
			if (!selection.width || !selection.height) {
				return true;
			}
			$('#param-x1').val(selection.x1);
			$('#param-y1').val(selection.y1);
			$('#param-size').val(selection.width);
		}
	});
	$('.imgareaselect-outer').live('click', function(){
		$('#param-x1, #param-y1, #param-size').val('');
	});
	$('#next-button').click(function(){
		if (!$('#param-x1').val() || !$('#param-y1').val() || !$('#param-size').val()) {
			alert('<?php echo __('Please select a photo area') ?>');
			return;
		}
		parent.$('.loading').show();
		$.ajax({
			url: '<?php echo $this->Html->url(array('controller' => 'upload', 'action' => 'cropProcessing')) ?>',
			type: 'POST',
			data: $('#crop-photo-form').serialize(),
			complete: function() {
				window.location.href = '<?php echo $this->Html->url(array('controller' => 'upload', 'action' => 'filter')) ?>';
			}
		});
	});
	
	$('#back-button').click(function(){
		window.location.href = '<?php echo $this->Html->url(array('controller' => 'upload', 'action' => 'start')) ?>';
	});
});
<?php echo $this->Html->scriptEnd() ?>
