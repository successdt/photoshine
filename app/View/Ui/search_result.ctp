
<div class="search-result">
	<?php for ($i = 0; $i < 32; $i++): ?>
		<div class="user-result">
			<a href="<?php echo $this->Html->url(array('controller' => 'Ui', 'action' => 'timeline')) ?>">
				<div class="margin10 result-avatar">
					<?php echo $this->Html->image('photoshine/common_default_avatar.png') ?>
				</div>
				<div class="result-name">
					<span class="ellipsis">
						<h5>thanhdd</h5>
					</span>
					<span class="ellipsis">
						<h6>Đào Duy Thành</h6>
					</span>
				</div>
			</a>
		</div>
		
		<div class="tag-result user-result">
			<a href="<?php echo $this->Html->url(array('controller' => 'Ui', 'action' => 'channel')) ?>">
				<div class="margin10">
				<?php
					for ($j = 1; $j <= 16; $j++):
						//echo $this->Html->image('http://placehold.it/50x50');
						echo $this->Html->image('tmp/tmp' . rand(1, 5) . '.jpg', array('width' => '48', 'height' => '48', 'class' => 'low'));
					endfor
				?>			
				</div>
				
				<div class="tag-name">
					<h4>#euro_travel</h4>
				</div>
				<div class="tag-user-counter ellipsis">
					<h2>500</h2>
					<span style="color: #FFF;">photos</span>
				</div>
				<div class="tag-photo-counter ellipsis">
					<h2>160</h2>
					<span style="color: #FFF;">users</span>
				</div>
			</a>
		</div>
	<?php endfor; ?>
</div>
<?php echo $this->Html->script(array('jquery.masonry.min', 'jquery.imagesloaded'), array('inline' => false)) ?>
<?php echo $this->Html->scriptStart(array('inline' => false)) ?>
//<script>
	$(document).ready(function(){
		$('.search-result').masonry({});	
	});
<?php echo $this->Html->scriptEnd() ?>