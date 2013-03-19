
<?php if(isset($data) && $data): ?>
<div class="alert alert-error" style="width: 400px; margin: 5px auto; text-align: center;" >
	<?php echo $data ?>
</div>
<?php endif ?>
<?php echo $this->Html->scriptStart(array('inline' =>false)) ?>
//<script>
$(document).ready(function(){
	parent.$('.loading').hide();
});
<?php echo $this->Html->scriptEnd() ?>