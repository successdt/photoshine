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
							<input class="input-xlarge" type="password" class="old-pass"/>
						</td>
					</tr>
					<tr>
						<td>
							New password
						</td>
						<td>
							<input class="input-xlarge" type="password" class="new-pass"/>
						</td>
					</tr>
					<tr>
						<td>
							New password confirmation
						</td>
						<td>
							<input class="input-xlarge" type="password" class="renew-pass"/>
						</td>
					</tr>
					<tr>
						<td></td>
						<td>
							<button class="btn btn-success">Change password</button>
						</td>
					</tr>
				</table>
			</div>
			<div class="edit-profile-footer btn-success"></div>
		</div>

	</div>
</div>