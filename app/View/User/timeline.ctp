<?php 
	if (!isset($data)) :
?>
	<h1>User not found</h1>
<?php else : ?>
<div class="timeline-cover-bg">
	<div>
	<?php
	if ($data['photo_count']){
		for ($i = 0; $i <= 100; $i++):
			$j = $i % count($data['Photo']);
			echo $this->Html->image($data['Photo'][$j]['Photo']['thumbnail'], array('width' => '50', 'height' => '50', 'class' => 'low'));
			if ($i % 4 == 0)
				echo $this->Html->image($data['Photo'][$j]['Photo']['thumbnail'], array('width' => '100', 'height' => '100', 'class' => 'hi'));
		endfor;		
	}
	?>	
	</div>

</div>
<div class="timeline-cover">
	<div class="timeline-cover-inner">
		<div class="timeline-info-bg"></div>
		<div class="timeline-cover-avatar">
			<?php echo $this->Html->image($data['User']['profile_picture']) ?>
			<div class="timeline-cover-username"><?php echo $data['User']['username'] ?></div>
		</div>
		<div class="timeline-cover-info">
			<div class="timeline-info-fullname">
				<?php
				if (isset($data['User']['first_name']) && $data['User']['first_name']){
					echo $data['User']['first_name'] . ' ';
				}
				if (isset($data['User']['last_name']) && $data['User']['last_name']){
					echo $data['User']['last_name'] ;
				}
				?>
			</div>
			<span>
				<i class="icon-home icon-white"></i>
				<?php
				$address = array();
				if ($data['User']['city']){
					$address[0] = $data['User']['city'];
				}
				if ($data['User']['country']){
					$address[1] = $data['User']['country'];
				}
				if (implode(', ', $address)){
					echo 'Live in ' . implode(', ', $address);
				}
			 	?>
			</span>
			<br />
			<span>
				<i class="icon-globe icon-white"></i>
				<?php
				if (isset($data['User']['website']) && $data['User']['website']){
					echo $this->Html->link($data['User']['website'], $data['User']['website']);
				}
				?>
			</span>
			<p>
				<i class="icon-user icon-white"></i>
				<?php 
				if (isset($data['User']['bio']) && $data['User']['bio']){
					echo $data['User']['bio'];
				}
			 	?>
			</p>
		</div>
		
		<div class="cover-user-static">
			<div class="photos-static timeline-stat">
				<div class="timeline-stat-inner">
					<?php
					$i = 1;
					foreach ($data['Photo'] as $photo){
						echo $this->Html->image($photo['Photo']['thumbnail'], array('width' => '50', 'height' => '50'));
						$i++;
						if ($i > 2)
							break;
					}?>
				</div>
				<div class="timeline-stat-text">
					<?php 
					if (isset($data['photo_count']) && ($data['photo_count'] > 1)){
						echo $data['photo_count'] . ' Photos';
					}
					elseif (isset($data['photo_count'])){
						echo $data['photo_count'] . ' Photo';
					}					
				 	?>
					 
				</div>
			</div>
			<div class="followers-static timeline-stat" style="cursor: pointer;">
				<div class="timeline-stat-inner">
					<?php
					foreach ($data['Follower'] as $follower){
						echo $this->Html->image($follower['User']['profile_picture'], array('width' => '50', 'height' => '50'));
					}?>
				</div>
				<div class="timeline-stat-text">
					<?php 
					if (isset($data['follower_count']) && ($data['follower_count'] > 1)){
						echo $data['follower_count'] . ' Followers';
					}
				 	elseif (isset($data['follower_count'])){
						echo $data['follower_count'] . ' Follower';
					}					
				 	?>
				</div>
			</div>
			<div class="following-static timeline-stat" style="cursor: pointer;">
				<div class="timeline-stat-inner">
					<?php
					foreach ($data['Following'] as $following){
						echo $this->Html->image($following['User']['profile_picture'], array('width' => '50', 'height' => '50'));
					}?>
				</div>
				<div class="timeline-stat-text">
					<?php
					if (isset($data['following_count'])){
						echo $data['following_count'] . ' Following';
					}
					?>
				</div>
			</div>
		</div>
		
		<div class="cover-btn-group">
			<?php if ($data['User']['id'] != AuthComponent::user('User.id')): ?>
				<div class="btn-group pull-right">
					<button class="btn follow-btn <?php echo ($data['you_are_following'] ? 'active' : 'Follow') . ' u' .$data['User']['id'] ?>" data-user-id="<?php echo $data['User']['id'] ?>">
						<?php echo $data['you_are_following'] ? 'Unfollow' : 'Follow' ?>
					</button>	  
					<button class="btn dropdown-toggle" data-toggle="dropdown">
				    	<span class="icon-align-justify"></span>
				  	</button>
					<ul class="dropdown-menu">
						<li><a href="#">Report user</a></a></li>
						<li><a href="#">Block user</a></li>
					<!-- dropdown menu links -->
					</ul>
				</div>
			<?php else: ?>
				<div class="btn-group pull-right">
					<?php echo $this->Html->link('Edit Profile', array('controller' => 'user', 'action' => 'editProfile'), array('class' => 'btn')) ?>
				</div>				
			<?php endif; ?>
		</div>
	</div>
</div>

<?php
	echo $this->element('photos_view', array(
		'requestUrl' => $this->Html->url(array('controller' => 'ajax', 'action' => 'callApi', 'getListPhotoOfUser')),
		'requestParams' => "id: '" . $data['User']['id'] . "'"
	));
?>
<?php echo $this->Html->script(array('jquery.masonry.min', 'jquery.imagesloaded'), array('inline' => false)) ?>
<?php echo $this->Html->scriptStart(array('inline' => false)) ?>
//<script>
	$(document).ready(function(){
		$('.timeline-cover-bg div img').imagesLoaded(function(){
			$('.timeline-cover-bg div').masonry({});	
		});
		$('.followers-static').click(function(){
			$('.loading').show();
			$().slidebox({
				iframe: true,
				width: 958,
				href: '<?php echo $this->Html->url(array('controller' => 'user', 'action' => 'follower', $data['User']['id'])) ?>'
			});
		});
		$('.following-static').click(function(){
			$('.loading').show();
			$().slidebox({
				iframe: true,
				width: 958,
				href: '<?php echo $this->Html->url(array('controller' => 'user', 'action' => 'following', $data['User']['id'])) ?>'
			});
		});
	});
<?php echo $this->Html->scriptEnd() ?>
<?php echo $this->element('follow') ?>
<?php endif ?>