<div id="home-wrapper">
	<div id="home-header" class="row-fluid">

		<div class="home-button-group pull-right margin10" style="margin-top: 11px;">
			<a class="btn btn-success" href="<?php echo $this->Html->url(array('controller' => 'home', 'action' => 'index')) ?>">Cancel</a>
			<a class="btn" href="<?php echo $this->Html->url(array('controller' => 'account', 'action' => 'login')) ?>">Log in</a>
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
				<input type="text" class="login-input" id="email" placeholder="Email"/>
				<input type="password" class="login-input" id="password" placeholder="Password"/>
			</div>
			<div style="width: 300px; margin: 0 auto;">
				<button class="btn btn-success submit" style="width: 100%;">Start</button>
			</div>			
			<div class="alert alert-error" style="width: 250px; margin: 5px auto;" >
				<span class="user-error block"></span>
				<span class="email-error block"></span>
				<span class="pass-error block"></span>
			</div>

		</div>

	</div>
	<div id="home-footer"></div>
</div>
<?php echo $this->Html->scriptStart(array('inline' =>false)) ?>
//<script>
$(document).ready(function(){
	var valid = {
		username : false,
		email : false,
		password : false
	}
	var lastCheckedUsername = '';
	

	$('#username').keyup(function(){
		var name = $(this).val();
		setTimeout(function(){
			checkUsername(name);
		}, 500)
	});
	$('#email').keyup(function(){
		var email = $(this).val();
		setTimeout(function(){
			checkEmail(email);
		}, 500)
	});
	
	$('#password').keyup(function(){
		var password = $(this).val();
		setTimeout(function(){
			checkPassword(password);
		}, 500)
	});
	
	$('.submit').click(function(){
		signup();
	});
	
	function checkUsername(username){
		var re = /^[\w\.@]{6,50}$/;
		var validation = re.test(username);
		
		if (!validation){
			valid.username = false; 
			$('.user-error').html('Invalid username format!');
		}
		else if (lastCheckedUsername != username) {
			lastCheckedUsername = username;			
			$('.loading').show();
			$.ajax({
				url : '<?php echo $this->Html->url(array('controller' => 'Ajax', 'action' => 'callApi', 'checkUser')) ?>',
				type : 'POST',
				data : {username : username},
				async : false,
				complete : function(response){
					var result = $.parseJSON(response.responseText);
					
					$('.loading').hide();
					if (!result.data.exiting){
						$('.user-error').html('');
						valid.username = true;
					}
					else {
						$('.user-error').html('Username is already in used');
						valid.username = false;
					}
				}
			});
		}		
	}
	
	function checkEmail(email){
		var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
		var validation = re.test(email);
		valid.email = validation;
		
		if (!validation){
			$('.email-error').html('Invalid email format!');
		}
		else {
			$('.email-error').html('');
		}
		
	}
	
	function checkPassword(password){
		if ((password.length > 16) || (password.length < 6)){
			$('.pass-error').html('Password must be 6-16 characters');
			valid.password = false;
		}
		else {
			$('.pass-error').html(' ');
			valid.password = true;
		}
	}
	
	function signup(){
		var username = $('#username').val();
		var password = $('#password').val();
		var email = $('#email').val();
		
		checkEmail(email);
		checkPassword(password);
		checkUsername(username);
		if (valid.username && valid.password && valid.email){
			$('.loading').show();
			$.ajax({
				url : '<?php echo $this->Html->url(array('controller' => 'Ajax', 'action' => 'callApi', 'registerUser')) ?>',
				type : 'POST',
				data : {username : username, password : password, email : email},
				complete : function(response){
					var result = $.parseJSON(response.responseText);
					
					$('.loading').hide();
					if (result.meta.success){
//						$('.user-error').html('Register successfully!');
						$('.login-group').html('');
						$('.submit').remove();
						window.location = '<?php echo $this->Html->url(array('controller' => 'home', 'action' => 'feed')) ?>';
					}
					else {
						$('.user-error').html(result.meta.error_message);
					}
				}
			});
		}
	}
});
<?php echo $this->Html->scriptEnd() ?>
