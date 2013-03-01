<div id="home-wrapper">
	<div id="home-header" class="row-fluid">

		<div class="home-button-group pull-right margin10" style="margin-top: 11px;">
			<a class="btn btn-success" href="<?php echo $this->Html->url(array('controller' => 'Ui', 'action' => 'home')) ?>">Cancel</a>
			<a class="btn" href="<?php echo $this->Html->url(array('controller' => 'Ui', 'action' => 'signup')) ?>">Sign up</a>
		</div>
	</div>
	<div id="home-content" style="width: 100%;">
		<div style="margin: 100px auto; width: 300px;">
			<div class="home-logo margin10" style="width: 235px; margin: 0 auto;">
				<?php echo $this->Html->image('photoshine/photoshine 100x100.png', array('width' => '32', 'height' => '32')) ?>
				<div class="site-name" style="margin: -23px 42px;">PhotoShine</div>
			</div>		
			<div class="login-group">
				<input type="text" class="login-input" id="username" placeholder="User name"/>
				<input type="password" class="login-input" id="password" placeholder="Password"/>
			</div>
			<div style="width: 300px; margin: 0 auto;">
				<button class="btn btn-success" style="width: 100%;">Log in</button>
				<span>
					<a href="#">Forgot your password?</a>
				</span>
			</div>
		</div>

	</div>
	<div id="home-footer"></div>
</div>