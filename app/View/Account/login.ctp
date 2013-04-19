<div id="home-wrapper">
	<div id="home-header" class="row-fluid">

		<div class="home-button-group pull-right margin10" style="margin-top: 11px;">
			<a class="btn btn-success" href="<?php echo $this->Html->url(array('controller' => 'Home', 'action' => 'index')) ?>">Cancel</a>
			<a class="btn" href="<?php echo $this->Html->url(array('controller' => 'account', 'action' => 'signup')) ?>">Sign up</a>
		</div>
	</div>
	<div id="home-content" style="width: 100%;">
		<div style="margin: 100px auto; width: 300px;">
			<div class="home-logo margin10" style="width: 235px; margin: 0 auto;">
				<?php echo $this->Html->image('photoshine/photoshine 100x100.png', array('width' => '32', 'height' => '32')) ?>
				<div class="site-name" style="margin: -23px 42px;">PhotoShine</div>
			</div>
			<form id="login-form" accept-charset="utf-8" method="post" action="#">
				<div class="login-group">
					<input type="text" name="data[username]" class="login-input" id="username" placeholder="User name"/>
					<input type="password" name="data[password]" class="login-input" id="password" placeholder="Password"/>
				</div>
				<div style="width: 300px; margin: 0 auto;">
					<button class="btn btn-success submit" name="data[submit]" style="width: 100%;">Log in</button>
					<span>
						<?php echo $this->Html->link(__('Forgot your password?'), 'javascript:resetPass()') ?>
					</span>
				</div>
			</form>
		</div>

	</div>
	<div id="home-footer"></div>
</div>
<?php echo $this->Html->scriptStart(array('inline' =>false)) ?>
//<script>
$(document).ready(function(){
	$('.submit').click(function(e){
		e.preventDefault();
		login();
	});
	$("#password").bind("keypress", function(event) {
	    if(event.which == 13) {
	    event.preventDefault();
	        login();
	    }
	});
	function login(){
		var username = $('#username').val();
		var password = $('#password').val();
		$('.loading').show();
		$.ajax({
			url : '<?php echo $this->Html->url(array('controller' => 'Ajax', 'action' => 'callApi', 'login')) ?>',
			type : 'POST',
			data : {username : username, password : password},
			complete : function(response){
				var result = $.parseJSON(response.responseText);
				
				$('.loading').hide();
				if (result.meta.success && (result.data.status == 'ok')){
					window.location.href = '<?php echo $this->Html->url(array('controller' => 'home', 'action' => 'feed')) ?>';
				}
				else {
					alert(result.meta.error_message + result.data.status);
				}
			}
		});		
	}

});
function resetPass(){
		var username = prompt('Enter your username to reset password');
		var re = /^[\w\.@]{6,50}$/;
		var validation = re.test(username);
		if (!validation){
			alert('Invalid username format!');
		}
		else {
			$('.loading').show();
			$.ajax({
				url : '<?php echo $this->Html->url(array('controller' => 'account', 'action' => 'resetPassword')) ?>',
				type : 'POST',
				data : {'username' : username},
				complete : function(response){
					var result = $.parseJSON(response.responseText);
					
					$('.loading').hide();
					if (result.meta.success && result.data.email){
						alert('A new password has been sent to email address: ' + result.data.email);
					}
					else {
						alert('error occurs');
					}
				}
			});				
		}
	}
<?php echo $this->Html->scriptEnd() ?>