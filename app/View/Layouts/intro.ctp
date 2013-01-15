<!DOCTYPE html>
<html lang="en">
<head>

	<meta charset="utf-8"/>
	<link rel="shortcut icon" href="<?php echo $this->Html->url('/img/favicon.ico') ?>" type="image/x-icon">
	<title>
		<?php echo $title_for_layout; ?>
	</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<meta name="description" content=""/>
	<meta name="author" content=""/>
	
	<?php echo $this->Html->css(array('bootstrap/css/bootstrap.min', 'colorbox/colorbox', 'intro'), 'stylesheet') ?>
	<?php echo $this->fetch('css'); ?>
</head>

<body>

	<div id="header" class="navbar-fixed-top">
	
		<div id="header-upper" class="row-fluid">
			<?php 
				echo $this->Html->link(
					$this->Html->image('meshtiles/logo_top.png'),
					'#',
					array('id' => 'logo', 'escape' => false)
				)
			?>
			
			<?php $userName = AuthComponent::user('info.user_name'); ?>
			<?php if (!$userName) : ?>
			<div class="pull-right">
				<a href="#" class="signup intro-btn"></a>
				<a href="#" class="login intro-btn"></a>
			</div>
			<?php endif; ?>
		</div>
		
	</div><!-- // END HEADER -->
	<div class="slide-container">
		<div class="homeslide">
			<div class="slide" style="padding-top: 40px">
				<?php echo $this->Html->image('meshtiles/home_slide_1.png')?>
				<div class="caption">
					<p class="title">Let's mesh the world with "meshtiles"!!</p>
					<p class="content">Get connected with people who love the same hobby, food, music, brand....no matter they're on the other side of the earth.
					<br>
					<br>
					A serendipity will happen by sharing photo.
					<br>
					<a href="#" class="meshlink">more about meshtiles apps</a>
					<br>
					<br>
					<div class="cta">
						<a href="#" class="fb pull-left"></a>
						<a href="#" class="tw pull-right"></a>
					</div>
				</div>
			</div>
			<div class="slide">
				<?php echo $this->Html->image('meshtiles/home_slide_2.png')?>
				<div class="caption">
					<p class="title">Let's mesh the world with "meshtiles"!!</p>
					<p class="content">Get connected with people who love the same hobby, food, music, brand....no matter they're on the other side of the earth.
					<br>
					<br>
					A serendipity will happen by sharing photo.
					<br>
					<a href="#" class="meshlink">more about meshtiles apps</a>
					<br>
					<br>
					<div class="cta">
						<a href="#" class="appstore pull-left"></a>
						<a href="#" class="gplay pull-right"></a>
					</div>
				</div>
			</div>
		</div>
		<div id="slide-nav">
			<a href="#"></a>
			<a href="#"></a>
		</div>
	</div>

	<div id="content">
		<?php echo $this->fetch('content'); ?>
	</div><!-- // END CONTENT -->

	<div id="footer">
		<div class="inner">
			<div class="pull-left">
				<span><?php echo $this->Html->link('Terms of use', array(''));?></span>
				<span><?php echo $this->Html->link('Privacy Policy', array(''));?></span>
				<span><?php echo $this->Html->link('Support', array(''));?></span>
				<span>Meshtiles &copy; copyright 2012, CellBridge Inc. All Rights Reserved</span>
			</div>
			<div class="pull-right">
				<?php 
					echo $this->Html->link(
						$this->Html->image('meshtiles/temp/fb.png'), '#', array('escape' => false));?>
				<?php 
					echo $this->Html->link(
						$this->Html->image('meshtiles/temp/tw.png'), '#', array('escape' => false));?>
				<?php 
					echo $this->Html->link(
						$this->Html->image('meshtiles/icon/home_fb.png'), '#', array('escape' => false));?>
				<?php 
					echo $this->Html->link(
						$this->Html->image('meshtiles/icon/home_tw.png'), '#', array('escape' => false));?>
			</div>
		</div>
	</div><!-- // END FOOTER -->
	
	<!-- LOGIN POPUP -->
	<?php if (!$userName) : ?>
		<div style="display: none;">
			<div id="login-popup">
				<div class="login-box">
					<div class="head"></div>
					
					<?php 
						echo $this->Form->create(false, array(
							'id' => 'login-form', 
							'inputDefaults' => array('label' => false),
							'url' => array('controller' => 'login', 'action' => 'index')
						));
		
						echo $this->Html->tag('label', '* '. __('username or password invalid'), array('class' => 'login-error-message'));
						
						echo $this->Form->input('username', array('placeholder' => __('Email or User name')));
						
						echo $this->Form->input('password', array('placeholder' => __('Password'), 'type' => 'password'));
						
						echo $this->Html->link(__('forget your password?'), '#', array('class' => 'yellow-link'));
						
						echo $this->Html->div(
							'row-fluid', 
							$this->Html->tag('div', '', array('class' => 'custom-checkbox pull-left'))
							.
							$this->Html->tag('div', '&nbsp;' . __('stay logged in'), array('class' => 'pull-left'))
						);
						
						echo $this->Form->input('remember', array('type' => 'hidden', 'value' => '0'));
						
						echo $this->Form->submit(__('LOGIN'), array('class' => 'btn'));
						
						echo $this->Form->end();
					?>
				</div>
			</div>
		</div>
	<?php endif;?>
	<!-- javascript
	================================================== -->
	<?php echo $this->Html->script(array(
		'jquery.min', 
		'bootstrap.min', 
		'jquery.colorbox',
		'modernizr',
		'jquery.cycle.js',
		'common'
	)) ?>
	
	<script type="text/javascript">
	function login() {
		$.colorbox({inline: true, innerWidth: '500px', innerHeight: '434px', close: '', href: '#login-popup', backButton: false, marginTop: 100});
	}
	
	$(document).ready(function(){
		<?php if (isset($turnLoginPopup)) : ?>
			login();
		<?php endif; ?>

		$('.signup').click(function(e){
			e.preventDefault();
			window.location = '<?php echo $this->Html->url(array('controller' => 'signup', 'action' => 'index')) ?>';
		});
		
		$('.login').click(function(e){
			e.preventDefault();
			login();
		});

		$('#login-popup input[type="submit"]').click(function(e){
			e.preventDefault();
			$('.login-error-message').css('visibility', 'hidden');
			$('.login-box .head').addClass('loading');
			
			$.ajax({
				url: '<?php echo $this->Html->url(array('controller' => 'login', 'action' => 'index')) ?>',
				type: 'POST',
				data: $('#login-form').serialize(),
				complete: function(response) {
					$('.login-box .head').removeClass('loading');
					
					var msg = $.trim(response.responseText);
					
					if (msg == 'API-ERR-L0001') {
						$('.login-error-message').css('visibility', 'visible');
					}
					if (msg == 'API-SUCCESS-200') {
						//$.colorbox.close();
						window.location = '<?php echo $loginRedirect ?>';
					}
				}
			})
		});
		
		$('.homeslide').cycle({
			pager: '#slide-nav',
			fx: 'scrollHorz',
			speed: 500,
			pagerAnchorBuilder: function(idx, slide) { 
		        // return selector string for existing anchor 
		        return '#slide-nav a:eq(' + idx + ')'; 
		    }
		});
	});
	</script>
	
	<?php echo $this->fetch('script'); ?>
</body>
</html>