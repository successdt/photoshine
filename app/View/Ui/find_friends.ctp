<div style="width: 100%; height: auto">
	<div class="edit-profile-wrapper">
		<?php echo $this->element('Layouts/sidebar') ?>
		<div class="edit-profile">
			<div class="edit-profile-header btn-success">Find Friends</div>
			<div class="edit-profile-body">
				<hr />
				<div class="row-fluid">
					<div class="span4">
						<a href="javascript:void(0)">
							<div class="find-fb-friend pull-right"></div>
						</a>
					</div>
					<div class="span4">
		                  <input type="text" class="find-friend-input" autocomplete="off" placeholder="Search for users..."/>
		                  <button class="btn find-friend-submit"><i class="icon-search icon-black"></i></button>
					</div>
					<div class="span4">
						<a href="javascript:void(0)">
							<div class="find-tw-friend pull-left"></div>
						</a>
					</div>
				</div>
				<hr />
				<div class="find-friend-wrapper row-fluid">
					<?php
						$snsImage = array('suggest_type_facebook.png', 'suggest_type_twitter.png', '')
					?>
					<?php for ($i = 0; $i < 32; $i++): ?>
						<div class="friend-result">
							
								<div class="pull-left image80">
									<a href="<?php echo $this->Html->url(array('controller' => 'Ui', 'action' => 'timeline')) ?>">
										<?php echo $this->Html->image('tmp/tmp' . rand(1, 10) . '.jpg', array('class' => 'image80')); ?>
									</a>
									<div class="sns-overlay">
										<?php echo $this->Html->image('photoshine/' . $snsImage[rand(0, 2)]) ?>
									</div>
								</div>
								
								<div class="ellipsis friend-result-name">
									<div class="btn-success find-result-follow-btn">Follow</div>
									<a href="<?php echo $this->Html->url(array('controller' => 'Ui', 'action' => 'timeline')) ?>">
										<span>
											thanhdd
										</span>
										<br />
										<span class="ellipsis" style="color: #666;">
											Đào Duy Thành
										</span>
									</a>
								</div>
							
						</div>
					<?php endfor; ?>
				</div>
			</div>
			<div class="edit-profile-footer btn-success"></div>
		</div>

	</div>
</div>
<?php echo $this->Html->scriptStart(array('inline' =>false)) ?>
//<script>
$(document).ready(function(){
	$('.find-tw-friend, .find-fb-friend').click(function(){
		$(this).toggleClass('active');
	});	
});
<?php echo $this->Html->scriptEnd() ?>