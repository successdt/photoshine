<div style="width: 100%; height: auto">
	<div class="edit-profile-wrapper">
	
		<?php echo $this->element('Layouts/sidebar') ?>
		<div class="edit-profile">
			<div class="edit-profile-header btn-success">Edit Profile</div>
			<div class="edit-profile-body">
				<div class="error-alert"></div>
				<table class="profile-table">
					<tr>
						<td style="width: 200px;">
							First Name
						</td>
						<td>
							<input class="input-xlarge" type="text" class="first-name" value="Duy Thành"/>
						</td>
					</tr>
					<tr>
						<td>
							Last Name
						</td>
						<td>
							<input class="input-xlarge" type="text" class="last-name" value="Đào"/>
						</td>
					</tr>
					<tr>
						<td>
							Email
						</td>
						<td>
							<span class="input-xlarge uneditable-input">thanhdd@lifetimetech.vn</span>
						</td>
					</tr>
					<tr>
						<td>
							Username
						</td>
						<td>
							<span class="input-xlarge uneditable-input">thanhdd</span>
						</td>
					</tr>
					<tr>
						<td>
							Website
						</td>
						<td>
							<input class="input-xlarge" type="text" class="website" value="http://facebook.com/successdt"/>
						</td>
					</tr>
					<tr>
						<td>
							Gender
						</td>
						<td>
							<label class="radio">
								<input type="radio" name="gender" id="optionsRadios1" value="1" checked>
								Male
							</label>
							<label class="radio">
								<input type="radio" name="gender" id="optionsRadios2" value="0">
								Female
							</label>
						</td>
					</tr>
					<tr>
						<td>
							City
						</td>
						<td>
							<input class="input-xlarge" type="text" class="city"/>
						</td>
					</tr>

					<tr>
						<td>
							Country
						</td>
						<td>
							<select class="country">
								<option>Russia</option>
								<option>Thailand</option>
								<option>Vantican</option>
								<option selected="selected">Vietnam</option>
								<option>Ukraine</option>
							</select>						
						</td>
					</tr>
					<tr>
						<td>
							Biography
						</td>
						<td>
							<textarea class="bio input-xlarge" rows="5" cols="30">PHP developer at lifetimetech.vn
							</textarea>					
						</td>
					</tr>
					<tr>
						<td></td>
						<td>
							<button class="btn btn-success">Save</button>
						</td>
					</tr>
				</table>
			</div>
			<div class="edit-profile-footer btn-success"></div>
		</div>

	</div>
</div>