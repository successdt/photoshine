<div id="home-wrapper">
	<div id="home-header" class="row-fluid">
		<div class="home-logo pull-left margin10">
			<?php echo $this->Html->image('photoshine/photoshine 100x100.png', array('width' => '32', 'height' => '32')) ?>
			PhotoShine
		</div>
		<div class="home-button-group pull-right margin10" style="margin-top: 11px;">
			<a class="btn btn-success" href="<?php echo $this->Html->url(array('controller' => 'account', 'action' => 'login')) ?>">Log in</a>
			<a class="btn" href="<?php echo $this->Html->url(array('controller' => 'account', 'action' => 'signup')) ?>">Sign up</a>
		</div>
	</div>
	<div id="home-content">
		<?php for ($i = 1; $i <= 64; $i++): ?>
			<?php if ($i % 4 == 0) :?>
				<div class="home-big-block">
					<div class="home-block-image">
						<?php echo $this->Html->image('tmp/tmp' . rand(1, 10) . '.jpg', array());?>
					</div>
					<div class="home-block-caption margin10">
						#travel on PhotoShine
					</div>
				</div>
			<?php else: ?>
				<div class="home-small-block">
					<div class="home-block-image">
						<?php echo $this->Html->image('tmp/tmp' . rand(1, 10) . '.jpg', array());?>
					</div>
					<div class="home-block-caption margin10">
						#travel on PhotoShine
					</div>
				</div>
			<?php endif; ?>
		<?php endfor ?>	
	</div>
	<div id="home-footer"></div>
</div>
<?php echo $this->Html->script(array('jquery.masonry.min', 'jquery.imagesloaded'), array('inline' => false)) ?>
<?php echo $this->Html->scriptStart(array('inline' => false)) ?>
//<script>
	$(document).ready(function(){
		$('#home-content').masonry();
	});
<?php echo $this->Html->scriptEnd() ?>