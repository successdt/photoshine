<?php echo $this->Html->css('photo') ?>
<div class="photodetail-wrapper">
	<div class="photodetail-photo">
		<?php echo $this->Html->image('tmp/tmp3_hi.jpg', array('width' => '600', 'height' => '600')) ?>
	</div>
	<div class="photodetail-caption">
		<?php echo $this->Html->link('successdt', array('controlller' => 'u', 'action' => 'successdt'), array('class' => 'author'));?>
		AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA<br /><br /><br /><br /><br /><br /><br />AAAAAAAAAAAAAA
	</div>
	<div class="photodetail-sns"></div>
	<div class="photodetail-list-like">@user @ltt</div>
	<div class="photodetail-list-comment"></div>
</div>