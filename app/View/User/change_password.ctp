<div style="width: 100%; height: auto">
	<div class="edit-profile-wrapper">
	
		<?php echo $this->element('Layouts/sidebar') ?>
		<div class="edit-profile">
			<div class="edit-profile-header btn-success">Change Password</div>
			<div class="edit-profile-body">
				<div class="error-alert"></div>
				<table class="profile-table">
					<tr>
						<td style="width: 300px;">
							Old Password
						</td>
						<td>
							<input class="input-xlarge" type="password" id="old-pass"/>
						</td>
					</tr>
					<tr>
						<td>
							New password
						</td>
						<td>
							<input class="input-xlarge" type="password" id="new-pass"/>
						</td>
					</tr>
					<tr>
						<td>
							New password confirmation
						</td>
						<td>
							<input class="input-xlarge" type="password" id="renew-pass"/>
						</td>
					</tr>
					<tr>
						<td></td>
						<td>
							<button class="btn btn-success" id="submit">Change password</button>
						</td>
					</tr>
				</table>
			</div>
			<div class="edit-profile-footer btn-success"></div>
		</div>

	</div>
</div>
<?php echo $this->Html->scriptStart(array('inline' =>false)) ?>
//<script>
$(document).ready(function(){
	var valid = {
		oldPassword : false,
		password : false,
		passwordRe : false
	}
	
	$('#submit').click(function(){
		changePassword();
	});

	function checkPassword(password){
		if ((password.length > 16) || (password.length < 6)){
			alert('Password must be 6-16 characters');
			return 0;
		}
		else {
			return 1;
		}
	}
	
	function checkNewPassword(password, passwordRe){
		if (password === passwordRe)
			return 1;
		else {
			alert('Password do not match');
			return 0;
		}
			
	}
	
	function changePassword(){
		var oldPassword = $('#old-pass').val();
		var password = $('#new-pass').val();
		var passwordRe = $('#renew-pass').val();
		
		valid.oldPassword  = checkPassword(oldPassword);
		valid.password  = checkPassword(password);
		valid.passwordRe = checkNewPassword(password, passwordRe);
		if (valid.oldPassword && valid.password && valid.passwordRe){
			$('.loading').show();
			$.ajax({
				url : '<?php echo $this->Html->url(array('controller' => 'Ajax', 'action' => 'callApi', 'changeYourPassword')) ?>',
				type : 'POST',
				data : {old_password : oldPassword, password : password},
				complete : function(response){
					var result = $.parseJSON(response.responseText);
					
					$('.loading').hide();
					if (result.meta.success){
						alert('Password\'s changed');
					}
					else {
						alert(result.meta.error_message);
					}
				}
			});
		}
	}
});
<?php echo $this->Html->scriptEnd() ?>