<?php if($isSuccess){?>
<?php echo $this->Html->scriptStart(array('inline' => false)) ?>
//<script>
$(document).ready(function(){
	var name = '<?php echo $name ?>';
	
	opener.$('.' + name).addClass('active on');
	window.close();
});
<?php echo $this->Html->scriptEnd()?>
<?php }?>