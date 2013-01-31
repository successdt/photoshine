<div style="width: 100%; height: auto">
	<div class="edit-profile-wrapper">
	
		<?php echo $this->element('Layouts/sidebar') ?>
		<div class="edit-profile">
			<div class="edit-profile-header btn-success">Link To Other Services</div>
			<div class="edit-profile-body">
				<hr />
				<div class="row-fluid">
					<div class="span3"><div class="set-sns-btn fb"></div></div>
					<div class="span3"><div class="set-sns-btn tw"></div></div>
					<div class="span3"><div class="set-sns-btn tb"></div></div>
					<div class="span3"><div class="set-sns-btn fl"></div></div>
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
$(document).ready(function(){
	$('.set-sns-btn').click(function(){
		$(this).toggleClass('active');
	})
});
<?php echo $this->Html->scriptEnd() ?>