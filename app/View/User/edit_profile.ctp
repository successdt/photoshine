<?php if(isset($user) && $user): ?>
<div style="width: 100%; height: auto">
	<div class="edit-profile-wrapper">
	
		<?php echo $this->element('Layouts/sidebar') ?>
		<div class="edit-profile">
			<div class="edit-profile-header btn-success">Edit Profile</div>
			<div class="edit-profile-body">
				<div class="error-alert"></div>
				<hr />
				<form method="POST" enctype="multipart/form-data" action="<?php echo $this->Html->url(array('controller' => 'user', 'action' => 'editProfileExec')) ?>">
					<table class="profile-table">
						<tr>
							<td style="width: 200px;">
								First Name
							</td>
							<td>
								<input class="input-xlarge" name="first_name" maxlength="50" type="text" value="<?php echo $user['first_name'] ?>"/>
							</td>
						</tr>
						<tr>
							<td>
								Last Name
							</td>
							<td>
								<input class="input-xlarge" name="last_name" maxlength="50" type="text"  value="<?php echo $user['last_name'] ?>"/>
							</td>
						</tr>
						<tr>
							<td>
								Email
							</td>
							<td>
								<span class="input-xlarge uneditable-input">
									<?php echo $user['email'] ?>
								</span>
							</td>
						</tr>
						<tr>
							<td>
								Username
							</td>
							<td>
								<span class="input-xlarge uneditable-input"><?php echo $user['username'] ?></span>
							</td>
						</tr>
						<tr>
							<td>
								Website
							</td>
							<td>
								<input class="input-xlarge" name="website" maxlength="100" type="text" value="<?php echo $user['website'] ?>"/>
							</td>
						</tr>
						<tr>
							<td>
								Gender
							</td>
							<td>
								<label class="radio">
									<input type="radio" name="gender" id="optionsRadios1" value="1" <?php if( $user['gender'] == '1') echo 'checked';?>>
									Male
								</label>
								<label class="radio">
									<input type="radio" name="gender" id="optionsRadios2" value="0" <?php if( $user['gender'] == '0') echo 'checked';?>>
									Female
								</label>
							</td>
						</tr>
						<tr>
							<td>
								City
							</td>
							<td>
								<input class="input-xlarge" name="city" maxlength="100" type="text" value="<?php echo $user['city'] ?>"/>
							</td>
						</tr>
	
						<tr>
							<td>
								Country
							</td>
							<td>
								<select  name="country">
									<option selected="selected" value="<?php echo $user['country'] ?>"><?php echo $user['country'] ?></option>
									<option value="Russia">Russia</option>
									<option value="Thailand">Thailand</option>
									<option value="Vantican">Vantican</option>
									<option class="Vietnam">Vietnam</option>
									<option value="Ukraine">Ukraine</option>
								</select>						
							</td>
						</tr>
						<tr>
							<td>
								Biography
							</td>
							<td>
								<textarea name="bio" maxlength="200" class="input-xlarge"  rows="5" cols="30"><?php echo $user['bio'] ?></textarea>
							</td>
						</tr>
						<tr>
							<td>Profile picture</td>
							<td>
								<div class="profile-img">
									<?php echo $this->Html->image($user['profile_picture']) ?>
								</div>
							</td>
						</tr>
						<tr>
							<td>Add a photo</td>
							<td>
								<a class="btn btn-success pull-left margin5 choose-btn" href="javascript:void(0)">
									<i class="icon-camera icon-white"></i>
									Choose
								</a>
								<span class="uneditable-input pull-left margin5 file-src" style="width: 153px;"></span>
								<input type="file" name="file" id="file" style="display: none;" />
							</td>
						</tr>
					</table>
			
					<hr />
					<input type="submit" value="Save" class="btn btn-success" style="margin-left: 200px;"  />
				</form>				
			</div>
			<div class="edit-profile-footer btn-success"></div>
		</div>

	</div>
</div>
<?php endif; ?>

<?php echo $this->Html->scriptStart(array('inline' =>false)) ?>
//<script>
$(document).ready(function(){
	 
	$('.choose-btn').click(function(){		
		$('#file').trigger('click');
		
	});
	$('#file').change(function(){
		$('.file-src').html($(this).val());
	});
	$('.upload-next').click(function(){
		parent.$('.loading').show();
	});
	
});
<?php echo $this->Html->scriptEnd() ?>